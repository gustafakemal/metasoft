<?php

namespace App\Models;

use CodeIgniter\Model;

class MFPackingModel extends Model
{
    protected $table = 'MF_Packing';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = ['id', 'kategori', 'nama', 'aktif', "added", 'added_by', 'updated', 'updated_by'];
    protected $validationRules = [
        'kategori' => 'required',
        'nama' => 'required',
    ];
    protected $validationMessages = [
        'kategori'        => [
            'required' => 'Field Kategori harus diisi.',
        ],
        'nama'        => [
            'required' => 'Field Nama Kategori harus diisi.',
        ],
    ];

    public function getOpsi($kategori)
    {
        $query = $this->where('kategori',$kategori)
                    ->where('aktif', 'Y')
                    ->orderBy('nama', 'asc')
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }
}
