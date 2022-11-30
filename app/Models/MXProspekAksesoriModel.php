<?php

namespace App\Models;

class MXProspekAksesoriModel extends \CodeIgniter\Model
{
    protected $table = 'MX_Prospek_Aksesori';
    protected $allowedFields = ['NoProspek', 'Alt', 'Aksesori'];

    public function getByProspekAlt($NoProspek, $Alt)
    {
        return $this->select('*')
                    ->join('MX_Aksesori', 'MX_Prospek_Aksesori.Aksesori = MX_Aksesori.ID')
                    ->where('MX_Prospek_Aksesori.NoProspek', $NoProspek)
                    ->where('MX_Prospek_Aksesori.Alt', $Alt)
                    ->get();
    }

    public function delByProspek($NoProspek, $Alt)
    {
        return $this->where('NoProspek', $NoProspek)
                    ->where('Alt', $Alt)
                    ->delete();
    }
}