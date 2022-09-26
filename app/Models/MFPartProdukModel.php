<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use CodeIgniter\Validation\ValidationInterface;

class MFPartProdukModel extends Model
{
    protected $table = 'MF_PartProduk';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = [
        'id', 'fgd', 'revisi', 'nama', 'tujuan_penggunaan', 'technical_draw', 'no_dokumen', 'panjang', 'lebar', 'tinggi', 'kertas', 'flute', 'metalize', 'inner_pack', 'jum_innerpack', 'outer_pack', 'jum_outerpack', 'deliver_pack', 'auto_pack', 'special_req', 'aktif', 'added', 'added_by', 'updated', 'updated_by', 'no_dokcr', 'file_dokcr'
    ];
    protected $validationRules = [];
    protected $validationMessages = [];

    protected function initialize()
    {
        $fields_req = ['nama', 'tujuan_penggunaan', 'panjang', 'lebar', 'tinggi', 'kertas', 'flute', 'inner_pack', 'jum_innerpack', 'outer_pack', 'jum_outerpack'];
        $validationRules = [];
        $validationMessages = [];
        foreach ($fields_req as $field) {
            $validationRules[$field] = 'required';
            $validationMessages[$field]['required'] = 'Field ' . $field . ' harus diisi';
        }
        $this->validationRules = $validationRules;
        $this->validationMessages = $validationMessages;
    }

    public function getEditingData($id)
    {
        $query = $this->select('MF_PartProduk.id, MF_PartProduk.fgd, MF_PartProduk.revisi, MF_PartProduk.nama, MF_PartProduk.tujuan_penggunaan, MF_PartProduk.technical_draw, MF_PartProduk.no_dokumen, MF_PartProduk.panjang, MF_PartProduk.lebar, MF_PartProduk.tinggi, MF_PartProduk.kertas, MF_PartProduk.flute, MF_PartProduk.metalize, MF_PartProduk.inner_pack, MF_PartProduk.jum_innerpack, MF_PartProduk.outer_pack, MF_PartProduk.jum_outerpack, MF_PartProduk.deliver_pack, MF_PartProduk.auto_pack, MF_PartProduk.special_req, MF_PartProduk.aktif, MF_PartProduk.added, MF_PartProduk.added_by, MF_PartProduk.updated, MF_PartProduk.updated_by, MF_PartProduk.no_dokcr, MF_PartProduk.file_dokcr, MF_JenisKertas.nama as nama_kertas, MF_JenisFlute.nama as nama_flute, P.nama as NamaInnerPack, V.nama as NamaOuterPack, D.nama as NamaDeliverPack')
            ->join('MF_JenisKertas', 'MF_PartProduk.kertas = MF_JenisKertas.id', 'left')
            ->join('MF_JenisFlute', 'MF_PartProduk.flute = MF_JenisFlute.id', 'left')
            ->join('MF_Packing as P', 'MF_PartProduk.inner_pack = P.id', 'left')
            ->join('MF_Packing as V', 'MF_PartProduk.outer_pack = V.id', 'left')
            ->join('MF_Packing as D', 'MF_PartProduk.deliver_pack = D.id', 'left')
            ->where('MF_PartProduk.id', $id)
            ->get();

        return $query->getResult();
    }

    public function updatePart($id, $data)
    {
        return $this->where('id', $id)
                    ->set($data)
                    ->update();
    }

    public function getAll()
    {
        return $this->orderBy('id', 'desc')
//                    ->where('aktif', 'Y')
                    ->get();
    }

    public function getMFProduk()
    {
        return $this->orderBy('nama_produk', 'asc')
            ->asObject()
            ->findAll();
    }

    public function getByFgd($fgd)
    {
        $query = $this->like('fgd', $fgd)
                    ->get();

        if($query->getNumRows() == 0) {
            return [];
        }

        return $query->getResult();
    }
    public function getByFgdNama3() {
        $db = \Config\Database::connect();
        $query = $db->query('select * from v_MF_Produk');

        return $query;
    }
    public function getByFgdNama($key)
    {
        $query = $this->where('aktif', 'Y')
                        ->like('fgd', $key, 'both')
                        ->orLike('nama', $key, 'both')
                        ->orderBy('added', 'desc')
                        ->get();

        if($query->getNumRows() == 0) {
            return [];
        }

        return $query->getResult();
    }
    
    public function idGenerator()
    {
//        return $this->lastIdCounter(8);
        return $this->datePrefix() . $this->lastIdCounter(8);
    }

    public function fgdGenerator()
    {
        return $this->datePrefix() . $this->lastIdCounter(4);
    }
    public function revGenerator($fgd)
    {
        $last_revisi = $this->selectMax('revisi')->where('fgd', $fgd)
                    ->first();
        $new_rev = $last_revisi['revisi'] + 1;
        return $new_rev;
        
    }
    private function lastIdCounter($length)
    {
        $id = ($this->get()->getLastRow() == null) ? 0 : $this->get()->getLastRow()->id;
        $last_id = (int)substr($id, 4);
        $new_id = $last_id + 1;
        return str_pad($new_id, $length, "0", STR_PAD_LEFT);
    }

    private function datePrefix()
    {
        return substr(Time::now()->getYear(), 2) . str_pad(Time::now()->getMonth(), 2, '0', STR_PAD_LEFT);
    }

    public function getById($id)
    {
        return $this->asObject()->find($id);
    }

    public function getByIds($ids)
    {
        return $this->whereIn('id', $ids)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getMaxId()
    {
        $query = $this->selectMax('id')->get();

        return (int)$query->getResult()[0]->id;
    }

    public function updateById($id, $data)
    {
        return $this->where('id', $id)
            ->set($data)
            ->update();
    }

    public function deleteById($id)
    {
        return $this->where('id', $id)
            ->delete();
    }

    public function getLastRev($id)
    {
        return $this->select('revisi')
                ->where('id', $id)
                ->get()
                ->getLastRow();
    }

    public function getDistinctiveFGD()
    {
        return $this->select('fgd')
                    ->distinct()
                    ->get();
    }

    public function getRevisiByFGD($fgd)
    {
        return $this->select('revisi')
                    ->where('fgd', $fgd)
                    ->distinct()
                    ->get();
    }

    public function getIDByFgdAndRevisi($fgd, $revisi)
    {
        return $this->select('id')
                    ->where('fgd', $fgd)
                    ->where('revisi', $revisi)
                    ->first();
    }
}
