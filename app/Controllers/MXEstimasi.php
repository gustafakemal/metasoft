<?php

namespace App\Controllers;

class MXEstimasi extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\MXProspectModel();
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return view('MXEstimasi/MXEstimasi_Queue', [
            'page_title' => 'Antrian Estimasi',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
        ]);
    }

    private function formSatuan($satuan, $pieces = null)
    {
        if ($satuan === 'R') {
            $arr = [
                'label' => 'Bottom',
                'form_name' => 'MeterRoll',
            ];
        } else {
            if ($pieces == 'CS') {
                $arr = [
                    'label' => 'Centre Seal',
                    'form_name' => 'CentreSeal',
                ];
            } else {
                $arr = [
                    'label' => 'Gusset',
                    'form_name' => 'Gusset',
                ];
            }
        }

        return $arr;
    }

    public function warnaTinta()
    {
        $tinta = (new \App\Models\MXJenisTinta())->getTinta();

        return $this->response->setJSON($tinta->getResult());
    }

    public function edit($noprospek, $alt)
    {
        $data = $this->model->getDetailByNoProspectAndAlt($noprospek, $alt);
        $qq = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($noprospek, $alt);
        $jml = (new \App\Models\MXProspekJumlahModel())->getByProspekAlt($noprospek, $alt);
        $jenistinta = (new \App\Models\MXMerkTintaModel())->where('Kategori', 'Jenis Tinta MX')
            ->where('OpsiVal', $data->getResult()[0]->JenisTinta)
            ->get();
//        $adhesive = (new \App\Models\MXMerkTintaModel())->where('Kategori', 'Jenis Adhesive MX')
//            ->get();
        $adhesive = (new \App\Models\MXAdhesiveModel())->asObject()->orderBy('nama', 'asc')->findAll();
        $tinta = (new \App\Models\MXJenisTinta())->getTinta();
        $prospek_tinta = (new \App\Models\MXProspekTinta())->getByNoProspekAndAlt($noprospek, $alt);

        $result = $data->getResult()[0];

        return view('MXEstimasi/MXEstimasi', [
            'page_title' => 'Antrian Estimasi',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'prospek_aksesori' => $qq->getResult(),
            'jumlah' => ($jml->getNumRows() > 0) ? $jml->getResult() : [],
            'data' => $result,
            'jenistinta' => ($jenistinta->getNumRows() > 0) ? $jenistinta->getResult()[0] : null,
            'adhesive' => $adhesive,
            'tinta' => $tinta->getResult(),
            'form_satuan' => $this->formSatuan($result->Roll_Pcs, $result->Finishing),
            'prospek_tinta' => $prospek_tinta->getResult()
        ]);
    }

    public function calculate()
    {
        $noprospek = $this->request->getGet('noprospek');
        $alt = $this->request->getGet('alt');

        $data = $this->model->getDetailByNoProspectAndAlt($noprospek, $alt)->getResult()[0];
        $data_aksesori = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($noprospek, $alt);

        $model_mx_estimasi = new \App\Models\MXEstimasiModel();

        $jumlah_pitch = $model_mx_estimasi->getPitch($data->Roll_Pcs, $data->Pitch);
        if (!$data->Finishing) {
            $color_bar = $model_mx_estimasi->getColorBar($data->Roll_Pcs, $data->Finishing);
        } else {
            $color_bar = '-';
        }
        $circum = $model_mx_estimasi->getCircum($data->Roll_Pcs, $data->Pitch);

        $data_jumlah = (new \App\Models\MXProspekJumlahModel())->getByProspekAlt($noprospek, $alt)->getResult();
        $jumlah_array = array_map(function ($item) {
            return $item->Jumlah;
        }, $data_jumlah);

        $kalkulasi_otomatis = [];
        foreach ($jumlah_array as $key => $row) {
            $running_meter = $model_mx_estimasi->getRunningMeter($data->Roll_Pcs, $row, (int)$data->Gusset, (int)$data->JumlahUp, (int)$data->Pitch, (int)$data->LebarFilm);
            $kalkulasi_otomatis[] = [
                    'JumlahUp' => $data->JumlahUp,
                    'LebarFilm' => $data->LebarFilm,
                    'JumlahPitch' => $jumlah_pitch,
                    'ColorBar' => $color_bar,
                    'RunningMeter' => $running_meter,
                    'Circum' => $circum,
                    ];

        }
        $res = $model_mx_estimasi->getFormulaOtomatis($noprospek, $alt, $data_jumlah[0]->Jumlah);
//        dd($res);

        $jenis_film = [];
        $jf_model = new \App\Models\MXJenisFilmModel();
        for($x=1;$x<=4;$x++) {
            $material = 'Material' . $x;
            $prop = $jf_model->getNama($data->{$material});
            $jenis_film[] = [
                'Layer' => 'Layer ' . $x,
                'Nama' => ($data->{$material}) ? $prop->nama : 0,
                'Tickness' => ($data->{$material}) ? number_format($prop->berat_jenis, 2) : 0,
                'Harga' => ($data->{$material}) ? number_format($prop->harga, 2) : 0,
                'Pemakaian' => '',
            ] ;
        }

        $prospek_tinta_model = (new \App\Models\MXProspekTinta())->getByNoProspekAndAlt($noprospek, $alt);

        return view('MXEstimasi/MXEstimasi_Preview', [
            'page_title' => 'Antrian Estimasi',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'data' => $data,
            'data_jumlah' => $data_jumlah,
            'jumlah_array' => $jumlah_array,
            'kalkulasi' => $kalkulasi_otomatis,
            'jenis_film' => $jenis_film,
            'jenis_tinta' => $prospek_tinta_model->getResult()
        ]);
    }

    public function submitKelengkapanData()
    {
        $data = $this->request->getPost();

        $model_mx_estimasi = new \App\Models\MXEstimasiModel();

        if( !$data['JumlahUp'] || !$data['LebarFilm'] || !$data['JenisAdhesive'] || !array_key_exists('warnatinta', $data) ) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Jumlah Up, Lebar Film & Adhesive harus diisi'
            ]);
        }

        $tinta_filter_check = array_filter($data['warnatinta'], fn($i) => $i !== '');
        $tinta_unique_check = array_unique($data['warnatinta']);
        $coverage_unique_check = array_unique($data['coverage']);

        if( count($tinta_filter_check) !== count($data['warnatinta']) || count($tinta_unique_check) !== count($data['warnatinta']) ) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Warna tinta tidak boleh kosong & unique'
            ]);
        }

        if( count($coverage_unique_check) !== count($data['coverage']) ) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Tiap coverage harus diisi'
            ]);
        }

        $data_tinta = $this->request->getPost('warnatinta');
        $data_coverage = $this->request->getPost('coverage');
        if (count($data_tinta) == 0 || count($data_tinta) != count($data_coverage)) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Tinta & coverage harus diisi',
            ]);
        }

        $data_upd = array_filter($data, function ($item) {
            return $item !== 'NoProspek' && $item !== 'Alt' && $item !== 'warnatinta' && $item !== 'coverage';
        }, ARRAY_FILTER_USE_KEY);

        $update_prospek = $this->model->updateData($data_upd, $data['NoProspek'], $data['Alt']);

        $data_prospek_tinta = [];
        for ($i = 0; $i < count($data_tinta); $i++) {
            $data_prospek_tinta[] = [
                'NoProspek' => $data['NoProspek'],
                'Alt' => $data['Alt'],
                'Tinta' => $data_tinta[$i],
                'Coverage' => $data_coverage[$i],
            ];
        }

        $del_ex_prospek_tinta = (new \App\Models\MXProspekTinta())->where('NoProspek', $data['NoProspek'])
                                                    ->where('Alt', $data['Alt'])
                                                    ->delete();
        $insert_prospek_tinta = (new \App\Models\MXProspekTinta())->insertBatch($data_prospek_tinta);

        if ($update_prospek && $insert_prospek_tinta) {
            return $this->response->setJSON([
                'success' => true,
                'redirect_uri' => base_url() . '/queueestimasi/calculate?noprospek=' . $data['NoProspek'] . '&alt=' . $data['Alt']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => true,
                'msg' => 'Terjadi kesalahan',
            ]);
        }
    }

    public function apiGetAll()
    {
        $query = $this->model->getByStatus(20);

        $sess_access = array_values(array_filter(session()->get('priv'), function ($item) {
            return $item->modul_id == 31;
        }));

        $results = [];
        if ($query->getNumRows() > 0) {
            foreach ($query->getResult() as $key => $row) {

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success edit-rev-item" href="' . site_url('queueestimasi/edit/' . $row->NoProspek . '/' . $row->Alt) . '" title="Edit"><i class="fas fa-calculator"></i></a>';

                $jml_model = new \App\Models\MXProspekJumlahModel();
                $jml_query = $jml_model->getByProspekAlt($row->NoProspek, $row->Alt);

                $jml = [];
                if ($jml_query->getNumRows() > 0) {
                    foreach ($jml_query->getResult() as $r) {
                        $jml[] = $r->Jumlah;
                    }
                } else {
                    $jml[] = 0;
                }

                $results[] = [
                    $key + 1,
                    $row->NoProspek,
                    $row->Alt,
                    $row->NamaProduk,
                    $row->NamaPemesan,
                    implode(', ', $jml),
                    $this->common->dateFormat($row->Created),
                    $row->CreatedByName,
                    $row->Catatan,
                    $edit,
                ];
            }
        }

        return $this->response->setJSON($results);
    }
}
