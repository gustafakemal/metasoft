<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    public function setModulTbl()
    {
        return $this->db->table('MF_Modul');
    }

    public function getModul()
    {
        return $this->setModulTbl()->orderBy('nama_modul', 'asc')
                    ->get();
    }
}