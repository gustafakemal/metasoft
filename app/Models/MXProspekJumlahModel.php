<?php

namespace App\Models;

class MXProspekJumlahModel extends \CodeIgniter\Model

{
    protected $table = 'MX_Prospek_Jumlah';
    protected $allowedFields = ['NoProspek', 'Alt', 'Jumlah', 'JumlahUp', 'LebarFilm', 'JumlahPitch', 'ColorBar', 'Circum', 'RunningMeter', 'Circum', 'RunningMeter', 'Waste', 'WastePersiapan', 'JumlahTruk', 'Estimator', 'Estimated', 'MOQ'];

    public function getByProspekAlt($NoProspek, $Alt)
    {
        return $this->select('*')
            ->where('NoProspek', $NoProspek)
            ->where('Alt', $Alt)
            ->get();
    }

    public function delByProspek($NoProspek, $Alt)
    {
        return $this->where('NoProspek', $NoProspek)
            ->where('Alt', $Alt)
            ->delete();
    }

    public function updateByProspekAltJumlah($NoProspek, $Alt, $Jumlah, $data)
    {

        return $this->where("NoProspek", $NoProspek)
            ->where("Alt", $Alt)
            ->where("Jumlah", $Jumlah)
            ->set($data)
            ->update();
    }
}
