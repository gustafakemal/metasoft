<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table = 'SalesID';
    protected $allowedFields = ['SalesID', 'SalesName', 'NIK', 'FlagAktif'];
    protected $validationRules = [
        'SalesName' => 'required',
    ];
    protected $validationMessages = [
        'SalesName'        => [
            'required' => 'Field Nama Sales harus diisi.',
        ],
    ];
    public function getOpsi()
    {
        $query = $this->where('FlagAktif', 'A')
                    ->orderBy('SalesName', 'asc')
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }
    public function getSales()
    {
        return $this->orderBy('SalesName', 'desc')
            ->asObject()
            ->findAll();
    }

    public function getById($id)
    {
        return $this->where('SalesID', $id)->findAll();
    }

    public function getMaxId()
    {
        $query = $this->selectMax('SalesID')->get();

        return (int)$query->getResult()[0]->SalesID;
    }

    public function updateById($id, $data)
    {
        return $this->where('SalesID', $id)
            ->set($data)
            ->update();
    }

    public function deleteById($id)
    {
        return $this->where('SalesID', $id)
            ->delete();
    }

    public function getName($SalesID)
    {
        $query = $this->select('SalesName')
                        ->where('SalesID', $SalesID)
                        ->get();

        if($query->getNumRows() > 0) {
            return $query->getResult()[0]->SalesName;
        } else {
            return null;
        }
    }
}
