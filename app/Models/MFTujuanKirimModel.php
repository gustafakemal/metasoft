<?php

namespace App\Models;

use CodeIgniter\Model;

class MFTujuanKirimModel extends Model
{
    protected $table = 'MF_TujuanKirim';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = ['id', 'tujuan', 'harga', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
    protected $validationRules = [
        'tujuan' => 'required',
        'harga' => 'required',
    ];
    protected $validationMessages = [
        'tujuan'        => [
            'required' => 'Field Tujuan Kirim harus diisi.',
        ],
        'harga'        => [
            'required' => 'Field Harga harus diisi.',
        ],
    ];
    public function getOpsi()
    {
        $query = $this->where('aktif', 'Y')
                    ->orderBy('tujuan', 'asc')
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }
    public function getMFTujuanKirim()
    {
        return $this->orderBy('tujuan', 'desc')
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
