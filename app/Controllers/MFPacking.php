<?php

namespace App\Controllers;

class MFPacking extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\MFPackingModel();
    }

    public function getSelectOptions($kategori)
    {
        $query = $this->model->getOpsi($kategori);

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->nama
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}