<?php

namespace App\Models;

class MXJenisTinta extends \CodeIgniter\Model
{
    protected $table = 'MX_JenisTinta';
    protected $allowedFields = ['nama', 'harga', 'aktif', 'added', 'added_by', 'merk'];

    public function getByMerk($merk)
    {
        $where = 'merk="'.$merk.'" OR merk=""';
        return $this->where('merk', $merk)
                    ->get();
    }

    public function getTinta()
    {
        return $this->select('id, nama, merk')
                    ->orderBy('nama', 'asc')
                    ->get();
    }
}