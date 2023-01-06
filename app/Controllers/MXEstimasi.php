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
        if($satuan === 'R') {
            $arr = [
                'label' => 'Bottom',
                'form_name' => 'MeterRoll'
            ];
        } else {
            if($pieces == 'CS') {
                $arr = [
                    'label' => 'Centre Seal',
                    'form_name' => 'CentreSeal'
                ];
            } else {
                $arr = [
                    'label' => 'Gusset',
                    'form_name' => 'Gusset'
                ];
            }
        }

        return $arr;
    }

    public function calculate($noprospek, $alt)
    {
        $data = $this->model->getDetailByNoProspectAndAlt($noprospek, $alt);
        $qq = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($noprospek, $alt);
        $jml = (new \App\Models\MXProspekJumlahModel())->getByProspekAlt($noprospek, $alt);
        $jenistinta = (new \App\Models\MXMerkTintaModel())->where('Kategori', 'Jenis Tinta MX')
                                                        ->where('OpsiVal', $data->getResult()[0]->JenisTinta)
                                                            ->get();
        $adhesive = (new \App\Models\MXMerkTintaModel())->where('Kategori', 'Jenis Adhesive MX')
            ->get();
        $tinta = (new \App\Models\MXJenisTinta())->getByMerk($jenistinta->getResult()[0]->OpsiTeks);

        return view('MXEstimasi/MXEstimasi', [
            'page_title' => 'Antrian Estimasi',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'prospek_aksesori' => $qq->getResult(),
            'jumlah' => ($jml->getNumRows() > 0) ? $jml->getResult() : [],
            'data' => $data->getResult()[0],
            'jenistinta' => ($jenistinta->getNumRows() > 0) ? $jenistinta->getResult()[0] : null,
            'adhesive' => $adhesive->getResult(),
            'tinta' => $tinta->getResult()
        ]);
    }

    public function apiGetAll()
    {
        $query = $this->model->getByStatus(20);

        $sess_access = array_values( array_filter(session()->get('priv'), function ($item) {
            return $item->modul_id == 31;
        }) );

        $results = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $key => $row) {

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success edit-rev-item" href="'. site_url('listprospek/edit/' . $row->NoProspek . '/' . $row->Alt) .'" title="Edit"><i class="fas fa-calculator"></i></a>';

                $jml_model = new \App\Models\MXProspekJumlahModel();
                $jml_query = $jml_model->getByProspekAlt($row->NoProspek, $row->Alt);

                $jml = [];
                if($jml_query->getNumRows() > 0) {
                    foreach($jml_query->getResult() as $r) {
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