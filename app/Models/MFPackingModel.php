<?php

namespace App\Models;

use CodeIgniter\Model;

class MFPackingModel extends Model
{
    protected $table = 'MF_Packing';
    protected $useTimestamps = true;
    protected $createdField = 'added';
    protected $updatedField = 'updated';
    protected $allowedFields = ['id', 'kategori', 'nama', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
    protected $validationRules = [
        'kategori' => 'required',
        'nama' => 'required',
    ];
    protected $validationMessages = [
        'kategori' => [
            'required' => 'Field Kategori harus diisi.',
        ],
        'nama' => [
            'required' => 'Field Nama Kategori harus diisi.',
        ],
    ];

    /**
     * @param $kategori
     * @return array
     */
    public function getOpsi($kategori): array
    {
        $query = $this->where('kategori', $kategori)
            ->where('aktif', 'Y')
            ->orderBy('nama', 'asc')
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }

    /**
     * @param $id
     * @param $kategori
     * @return null|string
     */
    public function getNama($id, $kategori)
    {
        $query = $this->select('nama')
            ->where('kategori', $kategori)
            ->where('aktif', 'Y')
            ->where('id', $id)
            ->get();
        if ($query->getNumRows() == 0) {
            return null;
        }

        return $query->getResult()[0]->nama;
    }
}
