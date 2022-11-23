<?php

namespace App\Models;

use CodeIgniter\Model;

class MFProsesFinishingModel extends Model
{
    protected $table = 'MF_ProsesFinishing';
    protected $useTimestamps = true;
    protected $createdField = 'added';
    protected $updatedField = 'updated';
    protected $allowedFields = ['id', 'proses', 'harga', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
    protected $validationRules = [
        'proses' => 'required',
        'harga' => 'required',
    ];
    protected $validationMessages = [
        'proses' => [
            'required' => 'Field Proses Finishing harus diisi.',
        ],
        'harga' => [
            'required' => 'Field Harga harus diisi.',
        ],
    ];

    /**
     * @return array
     */
    public function getOpsi(): array
    {
        $query = $this->where('aktif', 'Y')
            ->distinct(true)
            ->orderBy('proses', 'asc')
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
    public function getMFProsesFinishing(): array
    {
        return $this->orderBy('proses', 'desc')
            ->asObject()
            ->findAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($id): array
    {
        return $this->where('id', $id)->findAll();
    }

    /**
     * @return int
     */
    public function getMaxId(): int
    {
        $query = $this->selectMax('id')->get();

        return (int)$query->getResult()[0]->id;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * @throws \ReflectionException
     */
    public function updateById($id, $data): bool
    {
        return $this->where('id', $id)
            ->set($data)
            ->update();
    }

    /**
     * @param $id
     * @return bool|\CodeIgniter\Database\BaseResult
     */
    public function deleteById($id)
    {
        return $this->where('id', $id)
            ->delete();
    }
}
