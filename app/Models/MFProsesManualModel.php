<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProsesManualModel extends Model
{
    protected $table = 'MF_ProsesManual';
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
            'required' => 'Field Proses Manual harus diisi.',
        ],
        'harga'        => [
            'required' => 'Field Harga harus diisi.',
        ],
    ];

    public function getOpsi()
    {
        $query = $this->where('aktif', 'Y')
                    ->orderBy('proses', 'asc')
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }
    public function getMFProsesManual()
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
