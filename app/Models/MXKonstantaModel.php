<?php

namespace App\Models;

use CodeIgniter\Model;

class MXKonstantaModel extends Model
{
    protected $table = 'MX_Konstanta';
    protected $useTimestamps = true;
    protected $updatedField = 'updated';
    protected $allowedFields = ['id', 'kategori', 'nama', 'nilai', 'aktif', 'updated', 'updated_by'];
    protected $validationRules = [
        'nilai' => 'required',
    ];
    protected $validationMessages = [
        'nilai' => [
            'required' => 'Field Nilai harus diisi.',
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
    public function getMXKonstanta(): array
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
     * @param $kategori
     * @return array
     */
    public function getByKategori($kategori): array
    {
        return $this->where('kategori', $kategori)->findAll();
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
