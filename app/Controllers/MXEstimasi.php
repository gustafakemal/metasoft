<?php

namespace App\Controllers;

class MXEstimasi extends BaseController
{
//    private $model;

    public function __construct()
    {
//        $this->model = new \App\Models\MXProspectModel();
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
        $results = [[
            1,
            null,
            0,
            null,
            null,
            0,
            null,
            null,
            '-'
        ]];

        return $this->response->setJSON($results);
    }
}