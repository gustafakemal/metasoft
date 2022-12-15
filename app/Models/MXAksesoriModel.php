<?php

namespace App\Models;

class MXAksesoriModel extends \CodeIgniter\Model
{
    protected $table = 'MX_Aksesori';
    protected $useTimestamps = true;
    protected $createdField = 'added';
    protected $updatedField = 'updated';
    protected $allowedFields = ['nama', 'aktif', 'harga', 'updated_by', 'added_by'];
}