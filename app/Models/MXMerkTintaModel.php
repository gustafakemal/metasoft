<?php

namespace App\Models;

use CodeIgniter\Model;

class MXMerkTintaModel extends Model
{
    protected $table = 'MasterOpsi';
    protected $useTimestamps = false;
    protected $allowedFields = ['OpsiTeks', 'OpsiVal', 'Kategori', 'FlagAktif'];
    protected $validationRules = [
        'OpsiTeks' => 'required',
    ];
    protected $validationMessages = [
        'OpsiTeks' => [
            'required' => 'Field Nama Segmen harus diisi.',
        ],
    ];

    /**
     * @return array
     */
    public function getAll(): array
    {
        $query = $this->where('Kategori', 'Jenis Tinta MX')
            ->where('FlagAktif', 'A')
            ->orderBy('OpsiTeks', 'asc')
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }

    /**
     * @param $id
     * @return null|string
     */
    public function getName($id)
    {
        $query = $this->where('Kategori', 'Jenis Tinta MX')
            ->where('OpsiVal', $id)
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getResult()[0]->OpsiTeks;
        } else {
            return null;
        }
    }
}
