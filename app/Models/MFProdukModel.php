<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProdukModel extends Model
{
    protected $table = 'MF_Produk';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = ['id', 'fgd', 'revisi', 'nama_produk', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
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

    public function getById($id)
    {
        return $this->where('id', $id)->findAll();
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
}
