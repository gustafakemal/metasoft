<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
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
    private function get_widthwtrim($roll_pcs, $finishing, $lebar, $color_bar)
    {
        $widthwtrim = 0;
        if ($roll_pcs == 'R') {
            $widthwtrim = $lebar;
        } else {
            if ($finishing == 'CS') {
                $widthwtrim = $lebar + ($color_bar * 2);
            } elseif ($finishing == 'CS Gusset') {
                $widthwtrim = $lebar + ($color_bar * 2);
            } elseif ($finishing == '4SS') {
                $widthwtrim = $lebar + ($color_bar * 2);
            } elseif ($finishing == '3SS') {
                $widthwtrim = $lebar + ($color_bar * 4);
            } elseif ($finishing == 'STP') {
                $widthwtrim = $lebar;
            }
        }
    }
    public function getPitch($roll_pcs, $pitch)
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
            $circum = getPitch($roll_pcs, $pitch) * $pitch;
        } else {
            $circum = getPitch($roll_pcs, $pitch) * $pitch;
        }
        return $circum;
    }
    private function getTtlWdtAsli($roll_pcs, $jumlah_up)
    {
        $ttl_wdt_asli = 0;
        if ($roll_pcs == 'R') {
            $ttl_wdt_asli = $jumlah_up;
        } else {
            $ttl_wdt_asli = $jumlah_up;
        }
        return $ttl_wdt_asli;

    }
    private function getTtlWidth($jumlah_up)
    {
        $ukuran_film = 0.0000;
        $teks_sql = "select UkCetak_Awal, Ukuran_Film, Rubroll from MX_UkuranFilm ";
        $teks_sql .= "where UkCetak_Awal in (select max(UkCetak_Awal) from MX_UkuranFilm where UkCetak_Awal<=" . $ttl_wdt_asli . ")";
        $query_ukuranfilm = $this->query($teks_sql)->get();

        $result = $query_ukuranfilm->row();
        $ukuran_film = $result->Ukuran_Film;
        $rubroll = $result->Rubroll;
        return $ukuran_film;
    }
    private function getWaste($roll_pcs, $running_meter)
    {
        $waste = 0.0000;
       
        $teks_sql = "select Waste from MX_WasteRoll ";
        $teks_sql .= "where Awal in (select max(Awal) from MX_WasteRoll where Awal<=" . $running_meter . ")";
        $query_waste = $this->query($teks_sql)->get();

        $result = $query_waste->row();
        $waste = $result->Waste;
       
        return $waste;
    }
    private function getWastePersiapan($roll_pcs)
    {
        $wastepersiapan = 0.0000;
        $where = "kategori='Campuran' and nama='Waste Persiapan'";
        $query_konstanta = $this->select('*')
            ->from('MX_Konstanta')
            ->where($where)
            ->get();
        $result = $query_konstanta->row();
        $wastepersiapan = $result->nilai;
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
            } else {
                $colorbar = 8;
            }
        }
        return $colorbar;
    }

    public function getRunningMeter($roll_pcs, $jumlah, $meter_roll, $jumlah_up, $pitch, $lebar_film)
    {
        $running_meter = 0;
        if ($roll_pcs == 'R') {
            $running_meter = ($jumlah * $meter_roll) / $jumlah_up;
        } else {
            $running_meter = $jumlah * ($pitch / 1000) / $lebar_film;
        }
        return $running_meter;
    }
    public function getJumlahPcs($roll_pcs, $meter_roll, $pitch, $jumlah)
    {
        $jumlah_pcs = 0;
        if ($roll_pcs == 'R') {
            $jumlah_pcs = $meter_roll / ($pitch / 1000) * $jumlah;
        }else{
            $jumlah_pcs = $jumlah;
        }
        return $jumlah_pcs;
    }

    public function getPemakaianMaterial($roll_pcs, $finishing, $material, $lebar, $pitch, $tebalmat, $jumlahpcs, $waste, $lebar_film, $wastepersiapan)
    {
        $pemakaian = 0.0000;
        $where = "id=$material";
        $query_material = $this->select('*')
            ->from('MX_Material')
            ->where($where)
            ->get();
        $result = $query_material->row();
        $beratjenis = $result->BeratJenis;
        $harga = $result->Harga;

        $where = "kategori='Correction' and nama='Film'";
        $query_konstanta = $this->select('*')
            ->from('MX_Konstanta')
            ->where($where)
            ->get();
        $result = $query_konstanta->row();
        $corr_film = $result->nilai;

        if ($roll_pcs == 'R') {
            $pemakaian = ($lebar * $pitch * $tebalmat * $jumlahpcs * ($beratjenis / 1000000000) / (1 - $waste)) + ($lebar_film * $tebalmat * ($beratjenis / 1000000000) * $wastepersiapan) * $corr_film;
        }else{
            if(($finishing=='3SS')||($finishing=='STP')){
                $pemakaian = ($lebar * $pitch * $tebalmat * $jumlahpcs * ($beratjenis / 1000000000) / (1 - $waste)) + ($lebar_film * $tebalmat * ($beratjenis / 1000000000) * $wastepersiapan) * $corr_film;    
            }
        }
        $hasil = array();
        $biaya = $pemakaian * $harga;
        $hasil[] = ['biaya'=>$biaya,'pakai'=>$pemakaian];
        return $hasil;
    }
    public function getPakaiAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan, $material3, $material4){
        $pakaiadhesive = 0.0000;
        $coating_weight = 0;
        $where = "id=".$jenis_adhesive;
        $query_konstanta = $this->select('*')
            ->from('MX_Adhesive')
            ->where($where)
            ->get();
        $result = $query_konstanta->row();
        $coating_weight = $result->konstanta;

        $solid_content = 0;
        $where = "kategori = 'Solid Content' and nama='Adhesive'";
        $querySolidContent = $this->select('*')
            ->from('MX_Kostanta')
            ->where($where)
            ->get();
        $resultSolidContent = $querySolidContent->row();
        $solid_content = $resultSolidContent->nilai;

        $corr_adhesive = 0;
        $where = "kategori='Correction' and nama='Adhesive'";
        $queryCorrAdhesive = $this->select('*')
            ->from('MX_Konstanta')
            ->where($where)
            ->get();
        $resultCorrAdhesive = $queryCorrAdhesive->row();
        $corr_adhesive = $resultCorrAdhesive->nilai;

        $konst = 0;
        if($material3==0){
            $konst = 1;
        }else{
            if($material4==0){
                $konst = 2;
            }  else{
                $konst = 3;
            }
        }
        $luasan = (($lebar * $pitch * $jumlah_pcs/1000000)/(1-$waste))+($lebar_film * $waste_persiapan/1000);
        $pakaiadhesive = $coating_weight * $luasan/1000 * $solid_content * $konst * $corr_adhesive;
        $hasil = array();
        $hasil[] = ['CoatingWeight'=>$coating_weight,'SolidContent'=>$solid_content,'Luas'=>$luasan,'Pakai'=>$pakaiadhesive];
        return $hasil;
    }
    public function getPakaiSolventAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan, $material3, $material4){
        $pakaiadhesive = 0.0000;
        $coating_weight = 0;
        $where = "id=".$jenis_adhesive;
        $query_konstanta = $this->select('*')
            ->from('MX_Adhesive')
            ->where($where)
            ->get();
        $result = $query_konstanta->row();
        $coating_weight = $result->konstanta;

        $solid_content = 0;
        $where = "kategori = 'Solid Content' and nama='Solvent Adhesive'";
        $querySolidContent = $this->select('*')
            ->from('MX_Kostanta')
            ->where($where)
            ->get();
        $resultSolidContent = $querySolidContent->row();
        $solid_content = $resultSolidContent->nilai;

        $corr_adhesive = 0;
        $where = "kategori='Correction' and nama='Adhesive'";
        $queryCorrAdhesive = $this->select('*')
            ->from('MX_Konstanta')
            ->where($where)
            ->get();
        $resultCorrAdhesive = $queryCorrAdhesive->row();
        $corr_adhesive = $resultCorrAdhesive->nilai;

        $konst = 0;
        if($material3==0){
            $konst = 1;
        }else{
            if($material4==0){
                $konst = 2;
            }  else{
                $konst = 3;
            }
        }
        $luasan = (($lebar * $pitch * $jumlah_pcs/1000000)/(1-$waste))+($lebar_film * $waste_persiapan/1000);
        $pakaiadhesive = $coating_weight * $luasan/1000 * $solid_content * $konst * $corr_adhesive;
        $hasil[] = ['CoatingWeight'=>$coating_weight,'SolidContent'=>$solid_content,'Luas'=>$luasan,'Pakai'=>$pakaiadhesive];
        return $hasil;
    }
    public function getFormulaOtomatis($NoProspek, $Alt, $jumlah)
    {

        $this->load->model('MXProspectModel');
        $query_prospect = $this->MXProspectModel->getDetailByNoProspectAndAlt($NoProspek, $Alt);
        $res_prospect = $query_prospect->row();
        $res = array();
        $roll_pcs = $res_prospect->Roll_Pcs;
        $finishing = $res_prospect->Finishing;
        $pitch = $res_prospect->Pitch;
        $jumlahup = $res_prospect->JumlahUp;
        $lebarfilm = $res_prospect->LebarFilm;
        $meterroll = $res_prospect->MeterRoll;
        $tebal = $res_prospect->Tebal;
        $panjang = $res_prospect->Panjang;
        $lebar = $res_prospect->Lebar;
        $material1 = (!$res_prospect->Material1)?0:$res_prospect->Material1;
        $tebalmat1 = (!$res_prospect->Material1)?0:$res_prospect->TebalMat1;
        $material2 = (!$res_prospect->Material2)?0:$res_prospect->Material2;
        $tebalmat2 = (!$res_prospect->Material2)?0:$res_prospect->TebalMat2;
        $material3 = (!$res_prospect->Material3)?0:$res_prospect->Material3;
        $tebalmat3 = (!$res_prospect->Material3)?0:$res_prospect->TebalMat3;
        $material4 = (!$res_prospect->Material4)?0:$res_prospect->Material4;
        $tebalmat4 = (!$res_prospect->Material4)?0:$res_prospect->TebalMat4;
        $adhesive = $res_prospect->Adhesive;
        $jenis_adhesive = $res_prospect->JenisAdhesive;
        $kapasitas = $res_prospect->Kapsitas;

        $color_bar = $this->getColorBar($roll_pcs, $finishing);
        $width_w_trim = $this->get_widthwtrim($roll_pcs, $finishing);
        $jumlah_up = ($jumlahup == 0) ? $this->getJumlahUp($roll_pcs, $finishing, $color_bar, $width_w_trim) : $jumlahup;
        $lebar_film = ($lebarfilm == 0) ? $this->getTtlWidth($jumlah_up) : $lebarfilm;
        $jumlah_pitch = $this->getPitch($roll_pcs, $pitch);
        $circum = $this->getCircum($roll_pcs, $pitch);
        $running_meter = $this->getRunningMeter($roll_pcs, $jumlah, $meterroll, $jumlah_up, $pitch, $lebar_film);
        $waste = $this->getWaste($roll_pcs, $running_meter);
        $waste_persiapan = $this->getWastePersiapan($roll_pcs);
        $jumlah_pcs = $this->getJumlahPcs($roll_pcs, $meterroll, $pitch, $jumlah);
        $arrMaterial1 = array();
        $arrMaterial1[] = $this->getPemakaianMaterial($roll_pcs, $finishing, $material1, $lebar, $pitch, $tebalmat1, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
        $pakai_material1 = ($res_prospect->Material1==0)?0:$arrMaterial1['pakai'];
        $biaya_material1 = ($res_prospect->Material1==0)?0:$arrMaterial1['biaya'];
        $pakai_material2 = ($res_prospect->Material2==0)?0:$this->getPemakaianMaterial($roll_pcs, $finishing, $material2, $lebar, $pitch, $tebalmat2, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
        $pakai_material3 = ($res_prospect->Material3==0)?0:$this->getPemakaianMaterial($roll_pcs, $finishing, $material3, $lebar, $pitch, $tebalmat3, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
        $pakai_material4 = ($res_prospect->Material4==0)?0:$this->getPemakaianMaterial($roll_pcs, $finishing, $material4, $lebar, $pitch, $tebalmat4, $jumlah_pcs, $waste, $lebar_film, $waste_persiapan);
        
        $totalpakaimaterial = $pakai_material1 + $pakai_material2 + $pakai_material3 + $pakai_material4;

        $res = array();
        $res['NoProspek'] = $NoProspek;
        $res['Alt'] = $Alt;
        $res['Jumlah'] = $Jumlah;
        
        $res['roll_pcs'] = $roll_pcs;
        $res['jumlah_up'] = $jumlah_up;
        $res['lebar_film'] = $lebar_film;
        $res['jumlah_pitch'] = $jumlah_pitch;
        $res['color_bar'] = $color_bar;
        $res['circum'] = $circum;
        $res['running_meter'] = $running_meter;
        $res['waste'] = $waste;
        $res['waste_perisapan'] = $waste_persiapan;

        $where = "Kategori='Ratio Tinta Solvent MX'";
        $queryRatio = $this->select('CONVERT(money, OpsiVal) OpsiVal')
            ->from('MasterOpsi')
            ->where($where)
            ->get();
       
        $dataRatio = $queryRatio->result_array();

        $ratio_tinta=0;
        $ratio_solvent = 0;
        foreach ($dataRatio as $row):
            if($row['OpsiTeks']=='Tinta') $ratio_tinta = $row['Opsival'];
            if($row['OpsiTeks']=='Solvent') $ratio_solvent = $row['Opsival'];
        endforeach; 

        $where2 = "kategori='Correction' and nama='Tinta'";
        $query_konstanta2 = $this->select('*')
            ->from('MX_Konstanta')
            ->where($where2)
            ->get();
        $result2 = $query_konstanta2->row();
        $corr_tinta = $result2->nilai;

        $where2 = "kategori='Correction' and nama='Solvent'";
        $queryCorrSolvent = $this->select('*')
            ->from('MX_Konstanta')
            ->where($where2)
            ->get();
        $resultCorrSolvent = $queryCorrSolvent->row();
        $corr_solvent = $resultCorrSolvent->nilai;

        $where3 = "Kategori='Solvent Non OPP MX'";
        $querySolventNonOPP = $this->select('Opsiteks, CONVERT(money, OpsiVal) OpsiVal')
            ->from('MasterOpsi')
            ->where($where)
            ->get();
        $dataSolventNonOPP = $querySolventNonOPP->result_array();

        $toluene=0;
        $ia = 0;
        $mek = 0;
        $ipa = 0;
        foreach ($dataSolventNonOPP as $row):
            if($row['OpsiTeks']=='TOLUENE') $toluene = $row['Opsival'];
            if($row['OpsiTeks']=='IA') $ia = $row['Opsival'];
            if($row['OpsiTeks']=='MEK') $mek = $row['Opsival'];
            if($row['OpsiTeks']=='IPA') $ipa = $row['Opsival'];
        endforeach; 

        $where4 = "Kategori='Solvent OPP MX'";
        $querySolventOPP = $this->select('Opsiteks, CONVERT(money, OpsiVal) OpsiVal')
            ->from('MasterOpsi')
            ->where($where)
            ->get();
        $dataSolventOPP = $querySolventOPP->result_array();

        $tolueneOPP=0;
        $iaOPP = 0;
        $mekOPP = 0;
        $ipaOPP = 0;
        foreach ($dataSolventOPP as $row):
            if($row['OpsiTeks']=='TOLUENE') $tolueneOPP = $row['Opsival'];
            if($row['OpsiTeks']=='IA') $iaOPP = $row['Opsival'];
            if($row['OpsiTeks']=='MEK') $mekOPP = $row['Opsival'];
            if($row['OpsiTeks']=='IPA') $ipaOPP = $row['Opsival'];
        endforeach; 

        $where = "NoProspek='".$NoProspek."' AND Alt=".$Alt;
        $query_konstanta = $this->select('MX_Prospek_Tinta.Tinta Tinta, MX_Prospek_Tinta.Coverage Coverage, MX_JenisTinta.harga Harga, MX_JenisTinta.gsm Gsm')
            ->from('MX_Prospek_Tinta')
            ->join('MX_JenisTinta', 'MX_Prospek_Tinta.Tinta = MX_JenisTinta.id', 'left') 
            ->where($where)
            ->get();
        $result = $query_konstanta->row();
        $rawdata = $query_konstanta->result_array();
        $data_pakaitinta   =  array();
        $totalpakaitinta = 0;
        foreach ($rawdata as $row):                                                     
            $tinta = $row['Tinta'];
            $coverage = $row['Coverage'];
            $harga = $row['Harga'];
            $gsm = $row['Gsm'];
            $pakai = (($lebar * $pitch * $jumlah_pcs * $gsm * $ratio_tinta/1000000000) * $coverage/(1-$waste) + ($lebar_film * $gsm * $ratio_tinta/1000000) * $coverage * $waste_persiapan) * $corr_tinta;
            $biaya = $harga * $pakai;
            $totalpakaitinta += $pakai;
            $data_pakaitinta[] = ['tinta'=>$tinta,'harga'=>$harga,'pakai'=>$pakai,'biaya'=>$biaya];
        endforeach; 
        
        
        $query_hargasolvent = $this->select('upper(nama) nama, harga')
            ->from('MX_SolventTinta')
            ->get();
        $result = $query_hargasolvent->row();
        $rawdatahargasolvent = $query_hargasolvent->result_array();
        $hargasolvent = array();
        foreach ($rawdatahargasolvent as $row):      
                                                     
            $id = $row['id'];                                               
            $nama = $row['nama'];
            $harga = $row['harga'];
            $hargasolvent[$nama] = $i.";".$harga;
        endforeach;


        $query_hargaadhesive = $this->select('upper(nama) nama, konstanta, hargaadhesive, hargasolvent')
            ->from('MX_Adhesive')
            ->get();
        $result = $query_hargaadhesive->row();
        $rawdatahargaadhesive = $query_hargaadhesive->result_array();
        $hargaadhesive = array();
        $hargasolventadhesive = array();
        foreach ($rawdatahargaadhesive as $row):      
                                                     
            $id = $row['id'];                                               
            $nama = $row['nama'];
            $harga_solvent = $row['hargasolvent'];
            $harga_adhesive = $row['hargaadhesive'];
            $hargaadhesive[$nama] = $harga_solvent;
            $hargasolventadhesive[$nama] = $harga_adhesive;
        endforeach;

        $data_pakaisolvent   =  array();
        $Solvent = $totalpakaitinta * ($ratio_tinta/100) * ($ratio_solvent/100);
        $pakaiSolventNOPPToluene = $Solvent * $toluene/(1-$waste) *$corr_solvent;
        $pakaiSolventNOPPIA = $Solvent * $ia/(1-$waste) *$corr_solvent;
        $pakaiSolventNOPPMEK = $Solvent * $mek/(1-$waste) *$corr_solvent;
        $pakaiSolventNOPPIPA = $Solvent * $ipa/(1-$waste) *$corr_solvent;
        $pakaiSolventNonOPP = $pakaiSolventNOPPToluene + $pakaiSolventNOPPIA + $pakaiSolventNOPPMEK + $pakaiSolventNOPPIPA;
        $data_pakaisolvent[] = ['kategori'=>'NonOPP','jenis'=>explode(";",hargasolvent['TOLUENE'])[0],'pakai'=>$pakaiSolventNOPPToluene, 'harga'=>explode(";",hargasolvent['TOLUENE'])[1], 'biaya'=>$pakaiSolventNOPPToluene*explode(";",hargasolvent['TOLUENE'])[1]];
        $data_pakaisolvent[] = ['kategori'=>'NonOPP','jenis'=>explode(";",hargasolvent['IA'])[0],'pakai'=>$pakaiSolventNOPPIA, 'harga'=>explode(";",hargasolvent['IA'])[1], 'biaya'=>$pakaiSolventNOPPIA*explode(";",hargasolvent['IA'])[1]];
        $data_pakaisolvent[] = ['kategori'=>'NonOPP','jenis'=>explode(";",hargasolvent['MEK'])[0],'pakai'=>$pakaiSolventNOPPMEK, 'harga'=>explode(";",hargasolvent['MEK'])[1], 'biaya'=>$pakaiSolventNOPPMEK*explode(";",hargasolvent['MEK'])[1]];
        $data_pakaisolvent[] = ['kategori'=>'NonOPP','jenis'=>explode(";",hargasolvent['IPA'])[0],'pakai'=>$pakaiSolventNOPPIPA, 'harga'=>explode(";",hargasolvent['IPA'])[1], 'biaya'=>$pakaiSolventNOPPIPA*explode(";",hargasolvent['IPA'])[1]];


        $pakaiSolventOPPToluene = $Solvent * $tolueneOPP/(1-$waste) *$corr_solvent;
        $pakaiSolventOPPIA = $Solvent * $iaOPP/(1-$waste) *$corr_solvent;
        $pakaiSolventOPPMEK = $Solvent * $mekOPP/(1-$waste) *$corr_solvent;
        $pakaiSolventOPPIPA = $Solvent * $ipaOPP/(1-$waste) *$corr_solvent;
        $pakaiSolventOPP = $pakaiSolventOPPToluene + $pakaiSolventOPPIA + $pakaiSolventOPPMEK + $pakaiSolventOPPIPA;
        $data_pakaisolvent[] = ['kategori'=>'OPP','jenis'=>explode(";",hargasolvent['TOLUENE'])[0],'pakai'=>$pakaiSolventOPPToluene, 'harga'=>explode(";",hargasolvent['TOLUENE'])[1], 'biaya'=>$pakaiSolventOPPToluene*explode(";",hargasolvent['TOLUENE'])[1]];
        $data_pakaisolvent[] = ['kategori'=>'OPP','jenis'=>explode(";",hargasolvent['IA'])[0],'pakai'=>$pakaiSolventOPPIA, 'harga'=>explode(";",hargasolvent['IA'])[1], 'biaya'=>$pakaiSolventOPPIA*explode(";",hargasolvent['IA'])[1]];
        $data_pakaisolvent[] = ['kategori'=>'OPP','jenis'=>explode(";",hargasolvent['MEK'])[0],'pakai'=>$pakaiSolventOPPMEK, 'harga'=>explode(";",hargasolvent['MEK'])[1], 'biaya'=>$pakaiSolventOPPMEK*explode(";",hargasolvent['MEK'])[1]];
        $data_pakaisolvent[] = ['kategori'=>'OPP','jenis'=>explode(";",hargasolvent['IPA'])[0],'pakai'=>$pakaiSolventOPPIPA, 'harga'=>explode(";",hargasolvent['IPA'])[1], 'biaya'=>$pakaiSolventOPPIPA*explode(";",hargasolvent['IPA'])[1]];

        $data_pakaiadhesive   =  array();
        $pakaiAdhesive = $this->getPakaiAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs,$waste, $lebar_film, $waste_persiapan, $material3, $material4);
        $data_pakaiadhesive[] = ['kategori'=>'Adhesive','jenis'=>$jenis_adhesive,'coating_weight'=>$pakaiAdhesive['CoatingWeight'],'solid_content'=>$pakaiAdhesive['SolidContent'],'luas'=>$pakaiAdhesive['Luas'],'pakai'=>pakaiAdhesive['Pakai'], 'harga'=>hargaadhesive[strtoupper($jenis_adhesive)], 'biaya'=>pakaiAdhesive['Pakai']*hargaadhesive[strtoupper($jenis_adhesive)]];
        
        $pakaiSolventAdhesive = $this->getPakaiSolventAdhesive($roll_pcs, $jenis_adhesive, $lebar, $pitch, $jumlah_pcs,$waste, $lebar_film, $waste_persiapan, $material3, $material4);
        $data_pakaiadhesive[] = ['kategori'=>'Adhesive','jenis'=>$jenis_adhesive,'coating_weight'=>$pakaiSolventAdhesive['CoatingWeight'],'solid_content'=>$pakaiSolventAdhesive['SolidContent'],'luas'=>$pakaiSolventAdhesive['Luas'],'pakai'=>pakaiSolventAdhesive['Pakai'], 'harga'=>hargasolventadhesive[strtoupper($jenis_adhesive)], 'biaya'=>pakaiSolventAdhesive['Pakai']*hargasolventadhesive[strtoupper($jenis_adhesive)]];
        
       

        $jumlah_truk = CEIL(($totalpakaimaterial + $totalpakaitinta + $pakaiSolventNonOPP + $pakaiSolventOPP + $pakaiAdhesive + $pakaiSolventAdhesive)/($kapasitas*1000));
        $res['pakai_tinta'] = $data_pakaitinta;
        $res['pakai_solvent'] = $data_pakaisolvent;
        $res['pakai_totalsolventnopp'] = $pakaiSolventNonOPP;
        $res['pakai_totalsolventopp'] = $pakaiSolventOPP;
        $res['pakai_adhesive'] = $data_pakaiadhesive;
        $res['jumlah_truk'] = $jumlah_truk;
        return $res;

    }
    

 
}
