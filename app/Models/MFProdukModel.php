<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class MFProdukModel extends Model
{
    protected $table = 'MF_Produk';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = [
        'id', 'nama_produk', 'segmen', 'customer', 'sales', 'contact_person', 'tujuan_kirim', 'aktif', 'added', 'added_by', 'updated', 'updated_by'
    ];
    protected $validationRules = [];
    protected $validationMessages = [];

    public function getEditingData($id)
    {
        $query = $this->select('MF_Produk.id, MF_Produk.nama_produk, MF_Produk.contact_person, SalesID.SalesID, SalesID.SalesName, MF_TujuanKirim.id as tujuan_id, MF_TujuanKirim.tujuan, CustomerFile.NoPemesan, CustomerFile.NamaPemesan, MasterOpsi.OpsiVal, MasterOpsi.OpsiTeks')
                        ->join('SalesID', 'MF_Produk.sales = SalesID.SalesID', 'left')
                        ->join('MF_TujuanKirim', 'MF_Produk.tujuan_kirim = MF_TujuanKirim.id', 'left')
                        ->join('CustomerFile', 'MF_Produk.customer = CustomerFile.NoPemesan', 'left')
                        ->join('MasterOpsi', 'MF_Produk.segmen = MasterOpsi.OpsiVal', 'left')
                        ->where('MF_Produk.id', $id)
                        ->where('MF_Produk.aktif', 'Y')
                        ->where('MasterOpsi.Kategori', 'Segmen')
                        ->where('MasterOpsi.FlagAktif', 'A')
                        ->get();

        return $query->getResult();
    }

    protected function initialize()
    {
        $fields_req = ['id', 'nama_produk', 'segmen', 'customer', 'sales'];
        $validationRules = [];
        $validationMessages = [];
        foreach ($fields_req as $field) {
            $validationRules[$field] = 'required';
            $validationMessages[$field]['required'] = 'Field ' . $field . ' harus diisi';
        }
        $this->validationRules = $validationRules;
        $this->validationMessages = $validationMessages;
    }

    public function getMFProduk()
    {
        return $this->select('MF_Produk.id, MF_Produk.nama_produk, MF_Produk.segmen, MF_Produk.customer, MF_Produk.sales, MF_Produk.added, MF_Produk.added_by, MF_Produk.updated, MF_Produk.updated_by, MasterOpsi.OpsiTeks, CustomerFile.NamaPemesan, SalesID.SalesName')
                    ->join('MasterOpsi', 'MF_Produk.segmen = MasterOpsi.OpsiVal')
                    ->join('CustomerFile', 'MF_Produk.customer = CustomerFile.NoPemesan')
                    ->join('SalesID', 'MF_Produk.sales = SalesID.SalesID')
                    ->where('MasterOpsi.Kategori', 'Segmen')
                    ->get();
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
        $query = $this->like('nama_produk', $key, 'both')
                        ->where('aktif', 'Y')
                        ->get();

        if($query->getNumRows() == 0) {
            return [];
        }

        return $query->getResult();
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
        $id = $this->get()->getLastRow()->id;
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
        return $this->where('id', $id)
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

    public function idGenerator()
    {
        $query = $this->select('id')->get();
        $num = $query->getNumRows();
        $result = $query->getResult();

        if($num == 0) {
            return 1;
        }

        $end_result = end($result);

        if(($num > 0) && ($num == (int)$end_result->id)) {
            return (int)$end_result->id + 1;
        }

        for($i = 1;$i <= $num;$i++) {
            if( ! in_array($i, $result)) {
                return $i;
            }
        }
    }
}
