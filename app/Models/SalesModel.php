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
        'SalesName' => [
            'required' => 'Field Nama Sales harus diisi.',
        ],
    ];

    /**
     * @return array
     */
    public function getOpsi(): array
    {
        $query = $this->where('FlagAktif', 'A')
            ->orderBy('SalesName', 'asc')
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }

    /**
     * @return array
     */
    public function getSales(): array
    {
        return $this->orderBy('SalesName', 'desc')
            ->asObject()
            ->findAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($id): array
    {
        return $this->where('SalesID', $id)->findAll();
    }

    /**
     * @return int
     */
    public function getMaxId(): int
    {
        $query = $this->selectMax('SalesID')->get();

        return (int)$query->getResult()[0]->SalesID;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * @throws \ReflectionException
     */
    public function updateById($id, $data): bool
    {
        return $this->where('SalesID', $id)
            ->set($data)
            ->update();
    }

    /**
     * @param $id
     * @return bool|\CodeIgniter\Database\BaseResult
     */
    public function deleteById($id)
    {
        return $this->where('SalesID', $id)
            ->delete();
    }

    /**
     * @param $SalesID
     * @return null|string
     */
    public function getName($SalesID)
    {
        $query = $this->select('SalesName')
            ->where('SalesID', $SalesID)
            ->get();

        if ($query->getNumRows() > 0) {
            return $query->getResult()[0]->SalesName;
        } else {
            return null;
        }
    }
}
