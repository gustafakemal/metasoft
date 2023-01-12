<?php

namespace App\Models;

class MXEstimasiAdhesiveModel extends \CodeIgniter\Model

{
    protected $table = 'MX_Estimasi_Adhesive';
    protected $allowedFields = ['NoProspek', 'Alt', 'Jumlah', 'Kategori', 'Jenis', 'CoatingWeight', 'SolidContent', 'Luas', 'Harga', 'Pakai', 'Biaya'];

    public function getByProspekAltJumlahKatJenis($NoProspek, $Alt, $Jumlah, $Kategori, $Jenis)
    {
        return $this->select('*')
            ->where('NoProspek', $NoProspek)
            ->where('Alt', $Alt)
            ->where('Jumlah', $Jumlah)
            ->where('Kategori', $Kategori)
            ->where('Jenis', $Jenis)
            ->get();
    }

    public function updateByProspekAltJumlahKatJenis($NoProspek, $Alt, $Jumlah, $Kategori, $Jenis, $data)
    {

        return $this->where("NoProspek", $NoProspek)
            ->where("Alt", $Alt)
            ->where("Jumlah", $Jumlah)
            ->where('Kategori', $Kategori)
            ->where('Jenis', $Jenis)
            ->set($data)
            ->update();
    }
}
