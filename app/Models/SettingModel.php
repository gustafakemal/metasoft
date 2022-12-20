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

    public function getModulById($id)
    {
        return $this->setModulTbl()->where('id', $id)
            ->get();
    }

    public function deleteModulById($id)
    {
        return $this->setModulTbl()->where('id', $id)
            ->delete();
    }

    public function modulAccess($modul_id, $nik)
    {
        $table = $this->db->table('MF_ModulAccess');

        $query = $table->select('access')
                    ->where('modul', $modul_id)
                    ->where('nik', $nik)
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult()[0]->access;
        }

        return null;
    }

    public function getAccess($uid, $modul)
    {
        $table = $this->db->table('MF_ModulAccess');
        return $table->where('nik', $uid)
            ->where('modul', $modul)
            ->get();
    }

    public function deleteAccess($uid, $modul)
    {
        $table = $this->db->table('MF_ModulAccess');
        return $table->where('nik', $uid)
                    ->where('modul', $modul)
                    ->delete();
    }

    public function updateAccess($uid, $modul, $data)
    {
        $table = $this->db->table('MF_ModulAccess');
        return $table->where('nik', $uid)
            ->where('modul', $modul)
            ->set($data)
            ->update();
    }

    public function insertAccess($data)
    {
        $table = $this->db->table('MF_ModulAccess');

        return $table->insert($data);
    }
}