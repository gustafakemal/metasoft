<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProdukWarnaModel extends Model
{
    protected $table = 'MF_ProdukWarna';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = ['id_sisi', 'posisi', 'tinta', 'aktif', 'added', 'added_by', 'updated', 'updated_by'];

    public function getTintaBySisi($id_sisi)
    {
        $query = $this->select('*')
                        ->join('MF_JenisTinta', 'MF_ProdukWarna.tinta = MF_JenisTinta.id')
                        ->where('MF_ProdukWarna.id_sisi', $id_sisi)
                        ->get();

        return $query;
    }

    public function deleteAllSisi($id_sisi)
    {
        return $this->where('id_sisi', $id_sisi)
                    ->delete();
    }

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
