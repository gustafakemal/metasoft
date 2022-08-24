<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class MFPartProdukModel extends Model
{
    protected $table = 'MF_Produk';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = [
        'id', 'fgd', 'revisi', 'nama_produk', 'segmen', 'customer', 'sales', 'contact_person', 'tujuan_penggunaan', 'tujuan_kirim', 'technical_draw', 'no_dokumen', 'panjang', 'lebar', 'tinggi', 'kertas', 'flute', 'metalize', 'frontside', 'backside', 'inner_pack', 'jum_innerpack', 'outer_pack', 'jum_outerpack', 'deliver_pack', 'auto_pack', 'special_req', 'aktif', "added", 'added_by', 'updated', 'updated_by', 'no_dokcr', 'file_dokcr'
    ];
    protected $validationRules = [
        'nama_produk' => 'required',
    ];
    protected $validationMessages = [
        'nama_produk'        => [
            'required' => 'Field Nama Produk harus diisi.',
        ],
    ];

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
        // $db = \Config\Database::connect();
        // $sql = "select * from v_MF_Produk where upper(nama_produk) like upper('%$key%') or upper(fgd) like upper('%$key%')";
        // $query = $db->query("select * from v_MF_Produk where upper(nama_produk) like upper('%$key%') or upper(fgd) like upper('%$key%')");         
       
        $query = $this->like('fgd', $key, 'both')
                        ->get();

        if($query->getNumRows() == 0) {
            return [];
        }

        return $query->getResult();
    }
    
    public function idGenerator()
    {
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
        return $this->asObject()->find($id);
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
}
