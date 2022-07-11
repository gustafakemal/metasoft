<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProdukFinishingModel extends Model
{
    protected $table = 'MF_ProdukFinishing';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_produk', 'proses'];

    public function getByProdID($prod_id) {
    	$query = $this->select('MF_ProdukFinishing.proses as id, MF_ProsesFinishing.proses')
    					->join('MF_ProsesFinishing', 'MF_ProdukFinishing.proses = MF_ProsesFinishing.id')
    					->where('MF_ProdukFinishing.id_produk', $prod_id)
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
