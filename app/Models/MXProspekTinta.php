<?php

namespace App\Models;

class MXProspekTinta extends \CodeIgniter\Model
{
    protected $table = 'MX_Prospek_Tinta';
    protected $allowedFields = ['NoProspek', 'Alt', 'Tinta', 'Coverage'];

    public function getByNoProspekAndAlt($noprospek, $alt)
    {
        return $this->select('MX_Prospek_Tinta.*, JT.nama, JT.merk, JT.harga as hargatinta')
                    ->join('MX_JenisTinta JT', 'MX_Prospek_Tinta.Tinta = JT.id', 'left')
                    ->where('MX_Prospek_Tinta.NoProspek', $noprospek)
                    ->where('MX_Prospek_Tinta.Alt', $alt)
                    ->get();
    }
}