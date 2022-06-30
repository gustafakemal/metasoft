<?php

namespace App\Models;

use CodeIgniter\Model;

class MFJenisTintaModel extends Model
{
    protected $table = 'MF_JenisTinta';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = ['id', 'nama', 'harga', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
    protected $validationRules = [
        'nama' => 'required',
        'harga' => 'required',
    ];
    protected $validationMessages = [
        'nama'        => [
            'required' => 'Field Jenis Tinta harus diisi.',
        ],
        'harga'        => [
            'required' => 'Field Harga harus diisi.',
        ],
    ];
    public function getOpsi()
    {
        $query = $this->where('aktif', 'Y')
                    ->orderBy('nama', 'asc')
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }
    public function getMFJenisTinta()
    {
        return $this->orderBy('nama', 'desc')
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
