<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProdukKhususModel extends Model
{
    protected $table = 'MF_ProdukKhusus';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_sisi', 'proses'];

    public function getTintaBySisi($id_sisi)
    {
        $query = $this->select('*')
            ->join('MF_JenisTinta', 'MF_ProdukKhusus.proses = MF_JenisTinta.id')
            ->where('MF_ProdukKhusus.id_sisi', $id_sisi)
            ->get();

        return $query;
    }

    public function deleteAllSisi($id_sisi)
    {
        return $this->where('id_sisi', $id_sisi)
            ->delete();
    }

    public function getByProdID($prod_id) {
        $query = $this->select('MF_ProdukKhusus.proses as id, MF_ProsesKhusus.proses')
                        ->join('MF_ProsesKhusus', 'MF_ProdukKhusus.proses = MF_ProsesKhusus.id')
                        ->where('MF_ProdukKhusus.id_produk', $prod_id)
                        ->get();

        if($query->getNumRows() > 0) {
            return $query->getResult();
        }

        return [];
    }

    public function reInsert($data) {
        $ids = array_map(function($item) {
            return $item['id_produk'];
        }, $data);
        $this->whereIn('id_produk', $ids)
                ->delete();

        return $this->insertBatch($data);
    }

    public function deleteByProdID($prod_id) {
        return $this->where('id_produk', $prod_id)
                    ->delete();
    }
}
