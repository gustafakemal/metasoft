<?php

namespace App\Models;

use CodeIgniter\Model;

class MXProspectModel extends Model
{
    protected $table = '';

    protected $allowedFields = [];

    protected $validationRules = [
        'NamaProduk' => 'required',
    ];

    protected $validationMessages = [
        'NamaProduk'        => [
            'required' => 'Field Nama Produk harus diisi.',
        ],
    ];
}