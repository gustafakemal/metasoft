<?php

namespace App\Models;

use CodeIgniter\Model;

class MXEstimasiModel extends Model
{

    protected $table = 'MX_Prospek_Jumlah';
    protected $useTimestamps = true;
    protected $createdField = 'Created';
    protected $updatedField = 'Updated';
    protected $allowedFields = ['NoProspek', 'Alt', 'Tanggal', 'NamaProduk', 'Pemesan', 'Segmen', 'Konten', 'JenisProduk', 'Tebal', 'Panjang', 'Lebar', 'Pitch', 'Material1', 'TebalMat1', 'Material2', 'TebalMat2', 'Material3', 'TebalMat3', 'Material4', 'TebalMat4', 'Warna', 'Eyemark', 'RollDirection', 'Catatan', 'MaxJoin', 'WarnaTape', 'BagMaking', 'Bottom', 'OpenForFilling', 'Roll_Pcs', 'Finishing', 'Toleransi', 'Parsial', 'Keterangan', 'Area', 'Jalur', 'Kapasitas', 'Created', 'CreatedBy', 'Updated', 'UpdatedBy', 'Status', 'JenisTinta', 'JenisAdhesive', 'JenisPieces', 'Sales', 'Estimator', 'EstimasiUpdated', 'EstimasiUpdatedBy', 'EstimasiChecked', 'EstimasiCheckedBy', 'MeterRoll', 'Gusset', 'CentreSeal', 'Prioritas'];

    private function getJumlahUp($roll_pcs, $finishing, $color_bar, $width_w_trim)
    {
        $jumlah_up = 0;
        if ($roll_pcs == 'R') {
            $film_max = 1240;
            $jumlah_up = floor(($film_max - ($color_bar * 2)) / $width_w_trim);
        } else {
            if ($finishing == 'CS') {
                $film_max = 1240;
                $jumlah_up = floor(($film_max - ($color_bar * 2)) / $width_w_trim);
            } elseif ($finishing == 'CS Gusset') {
                $film_max = 1240;
                $jumlah_up = floor(($film_max - ($color_bar * 2)) / $width_w_trim);
            } elseif ($finishing == '3SS') {
                $film_max = 1240;
                $jumlah_up = floor(($film_max - ($color_bar * 2)) / $width_w_trim);
            } elseif ($finishing == 'STP') {
                $film_max = 1240;
                $jumlah_up = floor(($film_max - ($color_bar * 2)) / $width_w_trim);
            }

        }
        return $jumlah_up;
    }
    private function get_widthwtrim($roll_pcs, $finishing, $lebar_buka, $color_bar)
    {
        $widthwtrim = 0;
        if ($roll_pcs == 'R') {
            $widthwtrim = $lebar_buka;
        } else {
            if ($finishing == 'CS') {
                $widthwtrim = $lebar_buka + ($color_bar * 2);
            } elseif ($finishing == 'CS Gusset') {
                $widthwtrim = $lebar_buka + ($color_bar * 2);
            } elseif ($finishing == '4SS') {
                $widthwtrim = $lebar_buka + ($color_bar * 2);
            } elseif ($finishing == '3SS') {
                $widthwtrim = $lebar_buka + ($color_bar * 4);
            } elseif ($finishing == 'STP') {
                $widthwtrim = $lebar_buka;
            }
        }
        return $widthwtrim;
    }
    public function getJumlahPitch($roll_pcs, $pitch)
    {
        $jumlah_pitch = 0;
        if ($roll_pcs == 'R') {
            $jumlah_pitch = ceil(450 / $pitch);
        } else {
            $jumlah_pitch = ceil(450 / $pitch);
        }
        return $jumlah_pitch;
    }
    public function getCircum($roll_pcs, $pitch)
    {
        $circum = 0;
        if ($roll_pcs == 'R') {
            $circum = $this->getJumlahPitch($roll_pcs, $pitch) * $pitch;
        } else {
            $circum = $this->getJumlahPitch($roll_pcs, $pitch) * $pitch;
        }
        return $circum;
    }
    private function getTtlWdtAsli($roll_pcs, $width_w_trim, $jumlah_up)
    {
        $ttl_wdt_asli = 0;
        if ($roll_pcs == 'R') {
            $ttl_wdt_asli = $width_w_trim * $jumlah_up;
        } else {
            $ttl_wdt_asli = $width_w_trim * $jumlah_up;
        }
        return $ttl_wdt_asli;

    }
    private function getTtlWidth($ttl_wdt_asli)
    {
        $ukuran_film = 0.0000;
        $teks_sql = "select UkCetak_Awal, Ukuran_Film, Rubroll from MX_UkuranFilm ";
        $teks_sql .= "where UkCetak_Awal in (select max(UkCetak_Awal) from MX_UkuranFilm where UkCetak_Awal<=" . $ttl_wdt_asli . ")";
//        $query_ukuranfilm = $this->query($teks_sql)->get();
        $result = $this->query($teks_sql)->getResult();

        //      $result = $query_ukuranfilm->row();
        $ukuran_film = $result[0]->Ukuran_Film;
        $rubroll = $result[0]->Rubroll;
        //$ukuran_film = $result->Ukuran_Film;
        //$rubroll = $result->Rubroll;
        return $ukuran_film;
    }
    private function getWaste($roll_pcs, $running_meter)
    {
        $waste = 0.0000;

        $teks_sql = "select Waste from MX_WasteRoll ";
        $teks_sql .= "where Awal in (select max(Awal) from MX_WasteRoll where Awal<=" . $running_meter . ")";
        //$query_waste = $this->query($teks_sql)->get();
        //dd($teks_sql);
        $result = $this->query($teks_sql)->getResult();
        //dd($result);
        $waste = $result[0]->Waste;

        return $waste;
    }
    private function getWastePersiapan($roll_pcs)
    {
        $wastepersiapan = 0.0000;
        $teks_sql = "select nilai from MX_Konstanta ";
        $teks_sql .= "where kategori='Campuran' and nama='Waste Persiapan'";
        $result = $this->query($teks_sql)->getResult();
        //dd($teks_sql);
        $wastepersiapan = $result[0]->nilai;

        return $wastepersiapan;
    }
    public function getColorBar($roll_pcs, $finishing)
    {
        $colorbar = 0;
        if ($roll_pcs == 'R') {
            $colorbar = 0;
        } else {
            if ($finishing == '4SS') {
                $colorbar = 10;
            } elseif ($finishing == 'STP') {
                $colorbar = 6;
            } else {
                $colorbar = 8;
            }
        }
        return $colorbar;
    }

    public function getRunningMeter($roll_pcs, $finishing, $jumlah, $meter_roll, $jumlah_up, $pitch, $lebar_film)
    {
        $running_meter = 0;
        if ($roll_pcs == 'R') {
            $running_meter = ($jumlah * $meter_roll) / $jumlah_up;
        } else {
            $running_meter = $jumlah * ($pitch / 1000) / $jumlah_up;
        }
        return $running_meter;
    }
    public function getJumlahPcs($roll_pcs, $meter_roll, $pitch, $jumlah)
    {
        $jumlah_pcs = 0;
        if ($roll_pcs == 'R') {
            $jumlah_pcs = $meter_roll / ($pitch / 1000) * $jumlah;
        } else {
            $jumlah_pcs = $jumlah;
        }
        return $jumlah_pcs;
    }

    public function getPemakaianMaterial($roll_pcs, $finishing, $material, $lebar_buka, $pitch, $tebalmat, $jumlahpcs, $waste, $lebar_film, $wastepersiapan)
    {
        $pemakaian = 0.0000;
        $where = "id=$material";
        $tabel = $this->db->table('MX_JenisFilm');
        $query_material = $tabel->select('*')
            ->where($where)
            ->get();
        $result = $query_material->getResult();
        $row = $result[0];
        $beratjenis = $row->berat_jenis;
        $harga = $row->harga;
        //dd($beratjenis);

        $where = "kategori='Correction' and nama='Film'";
        $tabel = $this->db->table('MX_Konstanta');
        $query_konstanta = $tabel->select('*')
            ->where($where)
            ->get();
        $result = $query_konstanta->getResult();
        $row = $result[0];
        $corr_film = $row->nilai;
        //dd($corr_film);
        //dd($tebalmat);
        //dd($jumlahpcs);
        //dd($waste);

        if ($roll_pcs == 'R') {
            $pemakaian = (($lebar_buka * $tebalmat * $jumlahpcs * $beratjenis / 1000000000) * $pitch / (1 - $waste)) + (($lebar_film * $tebalmat * $beratjenis / 1000000) * $wastepersiapan) * $corr_film;
        } else {
            if (($finishing == '3SS') || ($finishing == 'STP')) {
                $pemakaian = (($lebar_buka * $tebalmat * $jumlahpcs * $beratjenis / 1000000000) * $pitch / (1 - $waste)) + (($lebar_film * $tebalmat * $beratjenis / 1000000) * $wastepersiapan) * $corr_film;
            } else if ($finishing == 'CS') {
                $pemakaian = (($lebar_buka * $tebalmat * $jumlahpcs * $beratjenis / 1000000000) * $pitch / (1 - $waste)) + (($lebar_film * $tebalmat * $beratjenis / 1000000) * $wastepersiapan) * $corr_film;

            }
        }
        $hasil = array();
        $biaya = $pemakaian * $harga;
        $hasil[] = ['harga' => $harga, 'biaya' => $biaya, 'pakai' => $pemakaian];

        return $hasil;
    }
    public function getPakaiAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan, $material3, $material4)
    {
        $pakaiadhesive = 0.0000;
        $coating_weight = 0;

        $where = "id=" . $jenis_adhesive;
        $tabel = $this->db->table('MX_Adhesive');
        $query_konstanta = $this->select('*')
            ->where($where)
            ->get();
        $result = $query_konstanta->getResult();
        $row = $result[0];
        $coating_weight = $row->konstanta;

        $solid_content = 0;
        $where = "kategori = 'Solid Content' and nama='Adhesive'";
        $tabel = $this->db->table('MX_Kostanta');
        $querySolidContent = $tabel->select('*')
            ->where($where)
            ->get();
        $resultSolidContent = $querySolidContent->getResult();
        $row = $result[0];
        $solid_content = $row->nilai;

        $corr_adhesive = 0;
        $where = "kategori='Correction' and nama='Adhesive'";
        $tabel = $this->db->table('MX_Kostanta');
        $queryCorrAdhesive = $tabel->select('*')
            ->where($where)
            ->get();
        $resultCorrAdhesive = $queryCorrAdhesive->getResult();
        $row = $result[0];
        $corr_adhesive = $row->nilai;

        $konst = 0;
        if ($material3 == 0) {
            $konst = 1;
        } else {
            if ($material4 == 0) {
                $konst = 2;
            } else {
                $konst = 3;
            }
        }
        $luasan = (($lebar * $pitch * $jumlah_pcs / 1000000) / (1 - $waste)) + ($lebar_film * $waste_persiapan / 1000);
        $pakaiadhesive = $coating_weight * $luasan / 1000 * $solid_content * $konst * $corr_adhesive;
        $hasil = array();
        $hasil[] = ['CoatingWeight' => $coating_weight, 'SolidContent' => $solid_content, 'Luas' => $luasan, 'Pakai' => $pakaiadhesive];
        return $hasil;
    }
    public function getPakaiSolventAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan, $material3, $material4)
    {
        $pakaiadhesive = 0.0000;
        $coating_weight = 0;
        $where = "id=" . $jenis_adhesive;
        $tabel = $this->db->table('MX_Adhesive');
        $query_konstanta = $tabel->select('*')
            ->where($where)
            ->get();
        $result = $query_konstanta->getResult();
        $row = $result[0];
        $coating_weight = $row->konstanta;

        $solid_content = 0;
        $where = "kategori = 'Solid Content' and nama='Solvent Adhesive'";
        $tabel = $this->db->table('MX_Kostanta');
        $querySolidContent = $tabel->select('*')
            ->where($where)
            ->get();
        $resultSolidContent = $querySolidContent > getResult();
        $row = $result[0];
        $solid_content = $row->nilai;

        $corr_adhesive = 0;
        $where = "kategori='Correction' and nama='Adhesive'";
        $tabel = $this->db->table('MX_Kostanta');
        $queryCorrAdhesive = $this->select('*')
            ->where($where)
            ->get();
        $resultCorrAdhesive = $queryCorrAdhesive > getResult();
        $row = $result[0];
        $corr_adhesive = $row->nilai;

        $konst = 0;
        if ($material3 == 0) {
            $konst = 1;
        } else {
            if ($material4 == 0) {
                $konst = 2;
            } else {
                $konst = 3;
            }
        }
        $luasan = (($lebar * $pitch * $jumlah_pcs / 1000000) / (1 - $waste)) + ($lebar_film * $waste_persiapan / 1000);
        $pakaiadhesive = $coating_weight * $luasan / 1000 * $solid_content * $konst * $corr_adhesive;
        $hasil[] = ['CoatingWeight' => $coating_weight, 'SolidContent' => $solid_content, 'Luas' => $luasan, 'Pakai' => $pakaiadhesive];
        return $hasil;
    }
    private function getLebarBuka($roll_pcs, $finishing, $lebar, $panjang, $centre_seal, $gusset, $meter_roll, $bottom, $color_bar)
    {
        $lebar_buka = 0;
        if ($roll_pcs == 'R') {
            $lebar_buka = $lebar;
        } else {
            if ($finishing == 'CS') {
                $lebar_buka = $lebar * 2 + $centre_seal * 2;
            } elseif ($finishing == 'CS Gusset') {
                $lebar_buka = $lebar * 2 + $gusset * 4 + 10 * 2;
            } elseif ($finishing == '4SS') {
                $lebar_buka = $lebar * 2 + $gusset * 4 + 10 * 2;
            } elseif ($finishing == '3SS') {
                $lebar_buka = $panjang * 2;
            } elseif ($finishing == 'STP') {
                $lebar_buka = $panjang * 2 + $bottom * 2 + $color_bar * 6;
                //dd($lebar_buka);
            }
        }

        return $lebar_buka;
    }
    public function getFormulaOtomatis($NoProspek, $Alt, $jumlah)
    {
        $tbl_opsi = $this->db->table('MasterOpsi');
        $tbl_konstanta = $this->db->table('MX_Konstanta');
        $tbl_tinta = $this->db->table('MX_Prospek_Tinta');
        $tbl_solventtinta = $this->db->table('MX_SolventTinta');
        $tbl_adhesive = $this->db->table('MX_Adhesive');
        $tbl_jenistinta = $this->db->table('MX_JenisTinta');
        $mxprospectmodel = new \App\Models\MXProspectModel();
        //$mxprospectmodel = $this->load->model('MXProspectModel');
        $query_prospect = $mxprospectmodel->getDetailByNoProspectAndAlt($NoProspek, $Alt);
        //return ($query_prospect);
        $res_prospect = $query_prospect->getResult();
        $data_prospect = $res_prospect[0];
        //return ($data_prospect);
        //return $data_prospect->Roll_Pcs;
        $res = array();
        $roll_pcs = $data_prospect->Roll_Pcs;
        $finishing = $data_prospect->Finishing;
        $jumlahup = $data_prospect->JumlahUp;
        $lebarfilm = $data_prospect->LebarFilm;
        $meterroll = $data_prospect->MeterRoll;
        $tebal = $data_prospect->Tebal;
        $panjang = $data_prospect->Panjang;
        $lebar = $data_prospect->Lebar;
        $pitch = ($roll_pcs == 'R') ? $panjang : $lebar;
        $centre_seal = ($data_prospect->CentreSeal) ? $data_prospect->CentreSeal : 0;
        $gusset = ($data_prospect->Gusset) ? $data_prospect->Gusset : 0;
        $ukuran_bottom = ($data_prospect->UkuranBottom) ? $data_prospect->UkuranBottom : 0;
        $meter_roll = ($data_prospect->MeterRoll) ? $data_prospect->MeterRoll : 0;
        $material1 = (!$data_prospect->Material1) ? 0 : $data_prospect->Material1;
        $tebalmat1 = (!$data_prospect->Material1) ? 0 : $data_prospect->TebalMat1;
        $material2 = (!$data_prospect->Material2) ? 0 : $data_prospect->Material2;
        $tebalmat2 = (!$data_prospect->Material2) ? 0 : $data_prospect->TebalMat2;
        $material3 = (!$data_prospect->Material3) ? 0 : $data_prospect->Material3;
        $tebalmat3 = (!$data_prospect->Material3) ? 0 : $data_prospect->TebalMat3;
        $material4 = (!$data_prospect->Material4) ? 0 : $data_prospect->Material4;
        $tebalmat4 = (!$data_prospect->Material4) ? 0 : $data_prospect->TebalMat4;
        $nama_produk = $data_prospect->NamaProduk;
        $jenis_adhesive = $data_prospect->JenisAdhesive;
        $jenis_tinta = $data_prospect->JenisTinta;

        $adhesive = ($jenis_adhesive == 0) ? '' : $data_prospect->Adhesive;
        $kapasitas = $data_prospect->Kapasitas;
        //dd($adhesive);
        $color_bar = $this->getColorBar($roll_pcs, $finishing);
        //dd($color_bar);
        $lebar_buka = $this->getLebarBuka($roll_pcs, $finishing, $lebar, $panjang, $centre_seal, $gusset, $meter_roll, $ukuran_bottom, $color_bar);
        //dd($lebar_buka);
        $width_w_trim = $this->get_widthwtrim($roll_pcs, $finishing, $lebar_buka, $color_bar);
        //dd($width_w_trim);
        $jumlah_up = ($jumlahup == 0) ? $this->getJumlahUp($roll_pcs, $finishing, $color_bar, $width_w_trim) : $jumlahup;
        //dd($jumlah_up);
        $ttl_wdt_asli = $this->getTtlWdtAsli($roll_pcs, $width_w_trim, $jumlah_up);
        //dd($ttl_wdt_asli);
        $ttl_width = $this->getTtlWidth($ttl_wdt_asli);
        //dd($ttl_width);
        $lebar_film = ($lebarfilm == 0) ? $ttl_width : $lebarfilm;
        //dd($lebar_film);
        $jumlah_pitch = $this->getJumlahPitch($roll_pcs, $pitch);
        //dd($jumlah_pitch);
        $circum = $this->getCircum($roll_pcs, $pitch);
        //dd($circum);
        $running_meter = $this->getRunningMeter($roll_pcs, $finishing, $jumlah, $meter_roll, $jumlah_up, $pitch, $lebar_film);
        //dd($running_meter);
        $waste = $this->getWaste($roll_pcs, $running_meter);
        //dd($waste);
        $waste_persiapan = $this->getWastePersiapan($roll_pcs);
        //dd($waste_persiapan);
        $jumlah_pcs = $this->getJumlahPcs($roll_pcs, $meterroll, $pitch, $jumlah);
        //dd($jumlah_pcs);
        $arrMaterial1 = array();
        $arrMaterial2 = array();
        $arrMaterial3 = array();
        $arrMaterial4 = array();
        $arrMaterial1 = $this->getPemakaianMaterial($roll_pcs, $finishing, $material1, $lebar_buka, $pitch, $tebalmat1, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
        //dd($arrMaterial1[0]['biaya']);
        $harga_material1 = ($data_prospect->Material1 == 0) ? 0 : $arrMaterial1[0]['harga'];
        $pakai_material1 = ($data_prospect->Material1 == 0) ? 0 : $arrMaterial1[0]['pakai'];
        $biaya_material1 = ($data_prospect->Material1 == 0) ? 0 : $arrMaterial1[0]['biaya'];
        $harga_material2 = 0;
        $pakai_material2 = 0;
        $biaya_material2 = 0;
        $harga_material3 = 0;
        $pakai_material3 = 0;
        $biaya_material3 = 0;
        $harga_material4 = 0;
        $pakai_material4 = 0;
        $biaya_material4 = 0;
        if ($data_prospect->Material2 != 0) {
            $arrMaterial2 = $this->getPemakaianMaterial($roll_pcs, $finishing, $material2, $lebar_buka, $pitch, $tebalmat2, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
            $harga_material2 = $arrMaterial2[0]['harga'];
            $pakai_material2 = $arrMaterial2[0]['pakai'];
            $biaya_material2 = $arrMaterial2[0]['biaya'];
        }
        if ($data_prospect->Material3 != 0) {
            //dd('Material3');
            $arrMaterial3 = $this->getPemakaianMaterial($roll_pcs, $finishing, $material3, $lebar_buka, $pitch, $tebalmat3, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
            $harga_material3 = $arrMaterial3[0]['harga'];
            $pakai_material3 = $arrMaterial3[0]['pakai'];
            $biaya_material3 = $arrMaterial3[0]['biaya'];
        }
        //dd($arrMaterial3);
        if ($data_prospect->Material4 != 0) {
            $arrMaterial4 = $this->getPemakaianMaterial($roll_pcs, $finishing, $material4, $lebar_buka, $pitch, $tebalmat4, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
            $harga_material4 = $arrMaterial4[0]['harga'];
            $pakai_material4 = $arrMaterial4[0]['pakai'];
            $biaya_material4 = $arrMaterial4[0]['biaya'];
        }
        //dd($arrMaterial4);
        $totalpakaimaterial = $pakai_material1 + $pakai_material2 + $pakai_material3 + $pakai_material4;
        //dd($totalpakaimaterial);
        $res = array();
        $res['NoProspek'] = $NoProspek;
        $res['Alt'] = $Alt;
        $res['Jumlah'] = $jumlah;

        $res['roll_pcs'] = $roll_pcs;
        $res['jumlah_up'] = $jumlah_up;
        $res['lebar_film'] = $lebar_film;
        $res['jumlah_pitch'] = $jumlah_pitch;
        $res['color_bar'] = $color_bar;
        $res['circum'] = $circum;
        $res['running_meter'] = $running_meter;
        $res['waste'] = $waste;
        $res['waste_perisapan'] = $waste_persiapan;
        $res['harga_material1'] = $harga_material1;
        $res['harga_material2'] = $harga_material2;
        $res['harga_material3'] = $harga_material3;
        $res['harga_material4'] = $harga_material4;
        $res['pakai_material1'] = $pakai_material1;
        $res['pakai_material2'] = $pakai_material2;
        $res['pakai_material3'] = $pakai_material3;
        $res['pakai_material4'] = $pakai_material4;
        $res['biaya_material1'] = $biaya_material1;
        $res['biaya_material2'] = $biaya_material2;
        $res['biaya_material3'] = $biaya_material3;
        $res['biaya_material4'] = $biaya_material4;

        //dd($res);
        $where = "Kategori='Ratio Tinta Solvent MX'";
        $queryRatio = $tbl_opsi->select('OpsiTeks, CONVERT(money, OpsiVal) OpsiVal')
            ->where($where)
            ->get();
        $dataRatio = $queryRatio->getResult();
        //dd($dataRatio);
        $ratio_tinta = 0;
        $ratio_solvent = 0;
        foreach ($dataRatio as $row):
            if ($row->OpsiTeks == 'Tinta') {
                $ratio_tinta = $row->OpsiVal;
            }

            if ($row->OpsiTeks == 'Solvent') {
                $ratio_solvent = $row->OpsiVal;
            }

        endforeach;
        //dd($ratio_tinta);
        $where2 = "kategori='Correction' and nama='Tinta'";
        $query_konstanta2 = $tbl_konstanta->select('*')
            ->where($where2)
            ->get();
        $resKonstanta2 = $query_konstanta2->getResult();
        $row = $resKonstanta2[0];
        $corr_tinta = $row->nilai;

        $where2 = "kategori='Correction' and nama='Solvent'";
        $queryCorrSolvent = $tbl_konstanta->select('*')
            ->where($where2)
            ->get();
        $resCorrSolvent = $queryCorrSolvent->getResult();
        $row = $resCorrSolvent[0];
        $corr_solvent = $row->nilai;

        $where3 = "Kategori='Solvent Non OPP MX'";
        $querySolventNonOPP = $tbl_opsi->select('OpsiTeks, CONVERT(money, OpsiVal) OpsiVal')
            ->where($where)
            ->get();
        $dataSolventNonOPP = $querySolventNonOPP->getResult();

        $toluene = 0;
        $ia = 0;
        $mek = 0;
        $ipa = 0;
        foreach ($dataSolventNonOPP as $row):
            if ($row->OpsiTeks == 'TOLUENE') {
                $toluene = $row->OpsiVal;
            }

            if ($row->OpsiTeks == 'IA') {
                $ia = $row->OpsiVal;
            }

            if ($row->OpsiTeks == 'MEK') {
                $mek = $row->OpsiVal;
            }

            if ($row->OpsiTeks == 'IPA') {
                $ipa = $row->OpsiVal;
            }

        endforeach;

        $where4 = "Kategori='Solvent OPP MX'";
        $querySolventOPP = $tbl_opsi->select('OpsiTeks, CONVERT(money, OpsiVal) OpsiVal')
            ->where($where)
            ->get();
        $dataSolventOPP = $querySolventOPP->getResult();

        $tolueneOPP = 0;
        $iaOPP = 0;
        $mekOPP = 0;
        $ipaOPP = 0;
        foreach ($dataSolventOPP as $row):
            if ($row->OpsiTeks == 'TOLUENE') {
                $tolueneOPP = $row->OpsiVal;
            }

            if ($row->OpsiTeks == 'IA') {
                $iaOPP = $row->OpsiVal;
            }

            if ($row->OpsiTeks == 'MEK') {
                $mekOPP = $row->OpsiVal;
            }

            if ($row->OpsiTeks == 'IPA') {
                $ipaOPP = $row->OpsiVal;
            }

        endforeach;
        //dd('Test 1');

        $where = "NoProspek='" . $NoProspek . "' AND Alt=" . $Alt;
        //dd($where);
        $query_konstanta = $tbl_tinta->select('MX_Prospek_Tinta.Tinta Tinta, MX_Prospek_Tinta.Coverage Coverage, MX_JenisTinta.harga Harga, MX_JenisTinta.gsm Gsm')
            ->join('MX_JenisTinta', 'MX_Prospek_Tinta.Tinta = MX_JenisTinta.id', 'left')
            ->where($where)
            ->get();
        $rawdata = $query_konstanta->getResult();
        //dd($rawdata);
        $data_pakaitinta = array();
        $totalpakaitinta = 0;
        foreach ($rawdata as $row):
            $tinta = $row->Tinta;
            $coverage = $row->Coverage;
            $harga = $row->Harga;
            $gsm = $row->Gsm;
            $pakai = (($lebar * $pitch * $jumlah_pcs * $gsm * $ratio_tinta / 1000000000) * $coverage / (1 - $waste) + ($lebar_film * $gsm * $ratio_tinta / 1000000) * $coverage * $waste_persiapan) * $corr_tinta;
            $biaya = $harga * $pakai;
            $totalpakaitinta += $pakai;
            $data_pakaitinta[] = ['tinta' => $tinta, 'harga' => $harga, 'pakai' => $pakai, 'biaya' => $biaya];
        endforeach;
        //dd($data_pakaitinta);

        $query_hargasolvent = $tbl_solventtinta->select('id, upper(nama) nama, harga')
            ->get();
        $rawdatahargasolvent = $query_hargasolvent->getResult();
        $hargasolvent = array();
        foreach ($rawdatahargasolvent as $row):

            $id = $row->id;
            $nama = trim($row->nama);
            $harga = $row->harga;
            $hargasolvent[$nama] = $id . ";" . $harga;
        endforeach;

        $query_hargaadhesive = $tbl_adhesive->select('id, upper(nama) nama, konstanta, hargaadhesive, hargasolvent')
            ->get();
        $rawdatahargaadhesive = $query_hargaadhesive->getResult();
        $hargaadhesive = array();
        $hargasolventadhesive = array();
        foreach ($rawdatahargaadhesive as $row):

            $id = $row->id;
            $nama = trim($row->nama);
            $harga_solvent = $row->hargasolvent;
            $harga_adhesive = $row->hargaadhesive;
            $hargaadhesive[$nama] = $harga_solvent;
            $hargasolventadhesive[$nama] = $harga_adhesive;
        endforeach;

        $data_pakaisolvent = array();
        $Solvent = $totalpakaitinta * ($ratio_tinta / 100) * ($ratio_solvent / 100);
        $pakaiSolventNOPPToluene = $Solvent * $toluene / (1 - $waste) * $corr_solvent;
        $pakaiSolventNOPPIA = $Solvent * $ia / (1 - $waste) * $corr_solvent;
        $pakaiSolventNOPPMEK = $Solvent * $mek / (1 - $waste) * $corr_solvent;
        $pakaiSolventNOPPIPA = $Solvent * $ipa / (1 - $waste) * $corr_solvent;
        $pakaiSolventNonOPP = $pakaiSolventNOPPToluene + $pakaiSolventNOPPIA + $pakaiSolventNOPPMEK + $pakaiSolventNOPPIPA;
        if (array_key_exists('TOLUENE', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'NonOPP', 'jenis' => explode(";", $hargasolvent['TOLUENE'])[0], 'pakai' => $pakaiSolventNOPPToluene, 'harga' => explode(";", $hargasolvent['TOLUENE'])[1], 'biaya' => $pakaiSolventNOPPToluene * explode(";", $hargasolvent['TOLUENE'])[1]];
        }

        if (array_key_exists('IA', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'NonOPP', 'jenis' => explode(";", $hargasolvent['IA'])[0], 'pakai' => $pakaiSolventNOPPIA, 'harga' => explode(";", $hargasolvent['IA'])[1], 'biaya' => $pakaiSolventNOPPIA * explode(";", $hargasolvent['IA'])[1]];
        }

        if (array_key_exists('MEK', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'NonOPP', 'jenis' => explode(";", $hargasolvent['MEK'])[0], 'pakai' => $pakaiSolventNOPPMEK, 'harga' => explode(";", $hargasolvent['MEK'])[1], 'biaya' => $pakaiSolventNOPPMEK * explode(";", $hargasolvent['MEK'])[1]];
        }

        if (array_key_exists('IPA', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'NonOPP', 'jenis' => explode(";", $hargasolvent['IPA'])[0], 'pakai' => $pakaiSolventNOPPIPA, 'harga' => explode(";", $hargasolvent['IPA'])[1], 'biaya' => $pakaiSolventNOPPIPA * explode(";", $hargasolvent['IPA'])[1]];
        }

        //dd($data_pakaisolvent);

        $pakaiSolventOPPToluene = $Solvent * $tolueneOPP / (1 - $waste) * $corr_solvent;
        $pakaiSolventOPPIA = $Solvent * $iaOPP / (1 - $waste) * $corr_solvent;
        $pakaiSolventOPPMEK = $Solvent * $mekOPP / (1 - $waste) * $corr_solvent;
        $pakaiSolventOPPIPA = $Solvent * $ipaOPP / (1 - $waste) * $corr_solvent;
        $pakaiSolventOPP = $pakaiSolventOPPToluene + $pakaiSolventOPPIA + $pakaiSolventOPPMEK + $pakaiSolventOPPIPA;
        if (array_key_exists('TOLUENE', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'OPP', 'jenis' => explode(";", $hargasolvent['TOLUENE'])[0], 'pakai' => $pakaiSolventOPPToluene, 'harga' => explode(";", $hargasolvent['TOLUENE'])[1], 'biaya' => $pakaiSolventOPPToluene * explode(";", $hargasolvent['TOLUENE'])[1]];
        }

        if (array_key_exists('IA', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'OPP', 'jenis' => explode(";", $hargasolvent['IA'])[0], 'pakai' => $pakaiSolventOPPIA, 'harga' => explode(";", $hargasolvent['IA'])[1], 'biaya' => $pakaiSolventOPPIA * explode(";", $hargasolvent['IA'])[1]];
        }

        if (array_key_exists('MEK', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'OPP', 'jenis' => explode(";", $hargasolvent['MEK'])[0], 'pakai' => $pakaiSolventOPPMEK, 'harga' => explode(";", $hargasolvent['MEK'])[1], 'biaya' => $pakaiSolventOPPMEK * explode(";", $hargasolvent['MEK'])[1]];
        }

        if (array_key_exists('IPA', $hargasolvent)) {
            $data_pakaisolvent[] = ['kategori' => 'OPP', 'jenis' => explode(";", $hargasolvent['IPA'])[0], 'pakai' => $pakaiSolventOPPIPA, 'harga' => explode(";", $hargasolvent['IPA'])[1], 'biaya' => $pakaiSolventOPPIPA * explode(";", $hargasolvent['IPA'])[1]];
        }

        //dd($data_pakaisolvent);

        $data_pakaiadhesive = array();
        $totalpakaiadhesive = 0;
        $totalpakaisolventadhesive = 0;
        if (!($jenis_adhesive == 0)) {
            //dd($jenis_adhesive);
            $pakaiAdhesive = $this->getPakaiAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan, $material3, $material4);
            $data_pakaiadhesive[] = ['kategori' => 'Adhesive', 'jenis' => $jenis_adhesive, 'coating_weight' => $pakaiAdhesive['CoatingWeight'], 'solid_content' => $pakaiAdhesive['SolidContent'], 'luas' => $pakaiAdhesive['Luas'], 'pakai' => pakaiAdhesive['Pakai'], 'harga' => hargaadhesive[strtoupper($jenis_adhesive)], 'biaya' => pakaiAdhesive['Pakai'] * hargaadhesive[strtoupper($jenis_adhesive)]];
            $pakaiSolventAdhesive = $this->getPakaiSolventAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan, $material3, $material4);
            $data_pakaiadhesive[] = ['kategori' => 'Adhesive', 'jenis' => $jenis_adhesive, 'coating_weight' => $pakaiSolventAdhesive['CoatingWeight'], 'solid_content' => $pakaiSolventAdhesive['SolidContent'], 'luas' => $pakaiSolventAdhesive['Luas'], 'pakai' => pakaiSolventAdhesive['Pakai'], 'harga' => hargasolventadhesive[strtoupper($jenis_adhesive)], 'biaya' => pakaiSolventAdhesive['Pakai'] * hargasolventadhesive[strtoupper($jenis_adhesive)]];
            $totalpakaiadhesive = pakaiAdhesive['Pakai'];
            $totalpakaisolventadhesive = pakaiSolventAdhesive['Pakai'];
        }

        //dd($data_pakaiadhesive);

        $jumlah_truk = CEIL(($totalpakaimaterial + $totalpakaitinta + $pakaiSolventNonOPP + $pakaiSolventOPP + $totalpakaiadhesive + $totalpakaisolventadhesive) / ($kapasitas * 1000));
        $res['pakai_tinta'] = $data_pakaitinta;
        $res['pakai_solvent'] = $data_pakaisolvent;
        $res['pakai_totalsolventnopp'] = $pakaiSolventNonOPP;
        $res['pakai_totalsolventopp'] = $pakaiSolventOPP;
        $res['pakai_adhesive'] = $data_pakaiadhesive;
        $res['jumlah_truk'] = $jumlah_truk;

        //dd($res);
        return $res;

    }

}
