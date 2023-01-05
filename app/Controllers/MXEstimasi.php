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
            'page_title' => 'Estimasi',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
        ]);
    }

    public function apiGetAll()
    {
        $query = $this->model->getByStatus(20);

        $sess_access = array_values( array_filter(session()->get('priv'), function ($item) {
            return $item->modul_id == 21;
        }) );

        $results = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $key => $row) {

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success edit-rev-item" href="'. site_url('listprospek/edit/' . $row->NoProspek . '/' . $row->Alt) .'" title="Edit"><i class="far fa-edit"></i></a>';
                $alt = '<a title="Tambah Alt" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-info alt-item" data-no-prospek="' . $row->NoProspek . '" data-alt="' . $row->Alt . '" href="#" title="Alt"><i class="far fa-clone"></i></a>';
                $hapus = '<a title="Hapus" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-danger del-prospek" data-no-prospek="' . $row->NoProspek . '" data-alt="' . $row->Alt . '" data-status="' . $row->Status . '" href="#"><i class="far fa-trash-alt"></i></a>';

                if($sess_access[0]->access == 3) {
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">' . $edit . $alt . $hapus . '</div>';
                } else {
                    $action = '<a title="Detail" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success" href="'. site_url('listprospek/detail/' . $row->NoProspek . '/' . $row->Alt) .'"><i class="far fa-file-alt"></i></a>';
                }

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
                    $row->CreatedByName,
                    implode(', ', $jml),
                    $this->common->dateFormat($row->Created),
                    $row->Catatan,
                    $action,
                ];
            }
        }

        return $this->response->setJSON($results);
    }
}