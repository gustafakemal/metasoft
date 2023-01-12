<?php

namespace App\Models;

class MXEstimasiSolventModel extends \CodeIgniter\Model

{
    protected $table = 'MX_Estimasi_Solvent';
    protected $allowedFields = ['NoProspek', 'Alt', 'Jumlah', 'Kategori', 'Jenis', 'Harga', 'Pakai', 'Biaya'];

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
