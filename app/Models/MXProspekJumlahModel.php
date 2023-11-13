<?php

namespace App\Models;

class MXProspekJumlahModel extends \CodeIgniter\Model

{
    protected $table = 'MX_Prospek_Jumlah';
    protected $allowedFields = ['NoProspek', 'Alt', 'Jumlah', 'JumlahUp', 'LebarFilm', 'JumlahPitch', 'ColorBar', 'Circum', 'RunningMeter', 'Circum', 'RunningMeter', 'Waste', 'WastePersiapan', 'JumlahTruk', 'Estimator', 'Estimated', 'MOQ'
        , 'PakaiMat1', 'PakaiMat2', 'PakaiMat3', 'PakaiMat4', 'HargaMat1', 'HargaMat2', 'HargaMat3', 'HargaMat4'
        , 'KatSolvent', 'PakaiToluene', 'PakaiIA', 'PakaiMEK', 'PakaiIPA', 'HargaToluene', 'HargaIA', 'HargaMEK', 'HargaIPA'
        , 'LuasAdhesive', 'PakaiAdhesive', 'HargaAdhesive', 'PakaiSolventAdhesive', 'HargaSolventAdhesive'
        , 'PakaiZipper', 'HargaZipper', 'HargaPacking', 'HargaTransport', 'GrandTotal', 'BiayaSatuan'
        , 'PersenManager', 'PersenJunior', 'PersenSenior',
    ];

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

    public function getByNoProspekAltJumlah($noprospek, $alt, $jumlah = 0, $moq = 0)
    {
        if (!($moq == 0)) {
            //dd("$noprospek, $alt, $jumlah, $moq");
            return $this->select('MX_Prospek_Jumlah.*')

                ->where('MX_Prospek_Jumlah.NoProspek', $noprospek)
                ->where('MX_Prospek_Jumlah.Alt', $alt)
                ->where('MX_Prospek_Jumlah.MOQ', $moq)
                ->get();
        } else {

            //dd("bb");
            return $this->select('MX_Prospek_Jumlah.*')

                ->where('MX_Prospek_Jumlah.NoProspek', $noprospek)
                ->where('MX_Prospek_Jumlah.Alt', $alt)
                ->where('MX_Prospek_Jumlah.Jumlah', $jumlah)
                ->where('MX_Prospek_Jumlah.MOQ', $moq)
                ->get();
        }
    }
}
