<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProdukWarnaModel extends Model
{
    protected $table = 'MF_ProdukWarna';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_produk', 'posisi', 'tinta'];

    public function getByProdID($prod_id, $position = '') {
    	if($position == '') {
    		$query = $this->select('MF_ProdukWarna.tinta, MF_JenisTinta.nama')
    					->join('MF_JenisTinta', 'MF_JenisTinta.id = MF_ProdukWarna.tinta')
    					->where('MF_ProdukWarna.id_produk', $prod_id)
    					->get();
    	} else {
    		$query = $this->select('MF_ProdukWarna.tinta, MF_JenisTinta.nama')
    					->join('MF_JenisTinta', 'MF_JenisTinta.id = MF_ProdukWarna.tinta')
    					->where('MF_ProdukWarna.id_produk', $prod_id)
    					->where('MF_ProdukWarna.posisi', $position)
    					->get();
    	}

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