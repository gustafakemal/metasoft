<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProdukManualModel extends Model
{
    protected $table = 'MF_ProdukManual';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_produk', 'proses'];

    public function getByProdID($prod_id) {
        $query = $this->select('MF_ProdukManual.proses as id, MF_ProsesManual.proses')
                        ->join('MF_ProsesManual', 'MF_ProdukManual.proses = MF_ProsesManual.id')
                        ->where('MF_ProdukManual.id_produk', $prod_id)
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
