<?php

namespace App\Models;

use CodeIgniter\Model;

class MXJenisKontenModel extends Model
{
    protected $table = 'MX_Konten';
    //protected $useTimestamps = true;
    //protected $createdField = 'added';
    //protected $updatedField = 'updated';
    protected $allowedFields = ['ID', 'Nama', 'Aktif'];
    protected $validationRules = [
        'Nama' => 'required|strtoupper',
    ];
    protected $validationMessages = [
        'Nama' => [
            'required' => 'Field Jenis Konten harus diisi.',
        ],
    ];

    /**
     * @return array
     */
    public function getOpsi(): array
    {
        $query = $this->where('Aktif', 'Y')
            ->orderBy('Nama', 'asc')
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
    public function getMXJenisKonten(): array
    {
        return $this->orderBy('Nama', 'asc')
            ->asObject()
            ->findAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($ID): array
    {
        return $this->where('ID', $ID)->findAll();
    }

    /**
     * @return int
     */
    public function getMaxId(): int
    {
        $query = $this->selectMax('ID')->get();

        return (int) $query->getResult()[0]->ID;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * @throws \ReflectionException
     */
    public function updateById($ID, $data): bool
    {
        return $this->where('ID', $ID)
            ->set($data)
            ->update();
    }

    /**
     * @param $id
     * @return bool|\CodeIgniter\Database\BaseResult
     */
    public function deleteById($ID)
    {
        return $this->where('ID', $ID)
            ->set(['Aktif' => 'T'])
            ->update();
    }
}
