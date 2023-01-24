<?php

namespace App\Models;

class MXMaterialModel extends \CodeIgniter\Model
{
    protected $table = 'MX_JenisFilm';
    protected $allowedFields = ['nama', 'harga', 'berat_jenis', 'aktif', 'added', 'added_by', 'updated', 'updated_by'];
}