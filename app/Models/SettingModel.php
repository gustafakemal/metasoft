<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    public function getModul()
    {
        $db = $this->db->table('MF_Modul');
        return $db->orderBy('nama_modul', 'asc')
                    ->get();
    }
}