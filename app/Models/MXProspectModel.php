<?php

namespace App\Models;

use CodeIgniter\Model;

class MXProspectModel extends Model
{
    /** Masukkan nama table nya */
    protected $table = '';

    /** Masukkan field-field dari table disini seluruhnya */
    protected $allowedFields = [];

    /** Mana field yang mandatory atau validation lainnya
     * Contohnya ini mengharuskan NamaProduk harus diisi (required)
     */
    protected $validationRules = [
        'NamaProduk' => 'required',
    ];

    /** Custom pesan kesalahan (default bhs inggris, diubah ke indo */
    protected $validationMessages = [
        'NamaProduk'        => [
            'required' => 'Field Nama Produk harus diisi.',
        ],
    ];
}