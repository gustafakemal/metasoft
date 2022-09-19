<?php

namespace App\Models;

use CodeIgniter\Model;

class SegmenModel extends Model
{
    protected $table = 'MasterOpsi';
    protected $useTimestamps = false;
    protected $allowedFields = ['OpsiTeks', 'OpsiVal', 'Kategori', 'FlagAktif'];
    protected $validationRules = [
        'OpsiTeks' => 'required',
    ];
    protected $validationMessages = [
        'OpsiTeks'        => [
            'required' => 'Field Nama Segmen harus diisi.',
        ],
    ];

    public function getAll()
    {
        $query = $this->where('Kategori', 'Segmen')
                    ->where('FlagAktif', 'A')
                    ->orderBy('OpsiTeks', 'asc')
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }

    public function getName($id)
    {
        $query = $this->where('Kategori', 'Segmen')
            ->where('OpsiVal', $id)
            ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult()[0]->OpsiTeks;
        } else {
            return null;
        }
    }
}
