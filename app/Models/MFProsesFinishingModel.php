<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProsesFinishingModel extends Model
{
    protected $table = 'MF_ProsesFinishing';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = ['id', 'proses', 'harga', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
    protected $validationRules = [
        'proses' => 'required',
        'harga' => 'required',
    ];
    protected $validationMessages = [
        'proses'        => [
            'required' => 'Field Proses Finishing harus diisi.',
        ],
        'harga'        => [
            'required' => 'Field Harga harus diisi.',
        ],
    ];

    public function getMFProsesFinishing()
    {
        return $this->orderBy('proses', 'desc')
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
