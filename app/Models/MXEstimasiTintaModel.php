<?php

namespace App\Models;

class MXEstimasiTintaModel extends \CodeIgniter\Model

{
    protected $table = 'MX_Estimasi_Tinta';
    protected $allowedFields = ['NoProspek', 'Alt', 'Jumlah', 'Tinta', 'Coverage', 'Harga', 'Pakai', 'Biaya'];

    public function getByProspekAltJumlahTinta($NoProspek, $Alt, $Jumlah, $Tinta)
    {
        return $this->select('*')
            ->where('NoProspek', $NoProspek)
            ->where('Alt', $Alt)
            ->where('Jumlah', $Jumlah)
            ->where('Tinta', $Tinta)
            ->get();
    }

    public function updateByProspekAltJumlahTinta($NoProspek, $Alt, $Jumlah, $Tinta, $data)
    {

        return $this->where("NoProspek", $NoProspek)
            ->where("Alt", $Alt)
            ->where("Jumlah", $Jumlah)
            ->where("Tinta", $Tinta)
            ->set($data)
            ->update();
    }
}
