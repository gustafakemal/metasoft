<?php

namespace App\Models;

class MXProspekTinta extends \CodeIgniter\Model
{
    protected $table = 'MX_Prospek_Tinta';
    protected $allowedFields = ['NoProspek', 'Alt', 'Tinta', 'Coverage'];
}