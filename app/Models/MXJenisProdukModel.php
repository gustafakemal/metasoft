<?php

namespace App\Models;

use CodeIgniter\Model;

class MXJenisProdukModel extends Model
{
    protected $table = 'MX_JenisProduk';
    protected $useTimestamps = true;
    protected $createdField = 'added';
    protected $updatedField = 'updated';
    protected $allowedFields = ['id', 'nama', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
    protected $validationRules = [
        'nama' => 'required',
    ];
    protected $validationMessages = [
        'nama' => [
            'required' => 'Field Jenis Produk harus diisi.',
        ],
    ];

    /**
     * @return array
     */
    public function getOpsi(): array
    {
        $query = $this->where('aktif', 'Y')
            ->orderBy('nama', 'asc')
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
    public function getMXJenisProduk(): array
    {
        return $this->orderBy('nama', 'desc')
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

        return (int) $query->getResult()[0]->id;
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
