<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class MFPacking extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\MFPackingModel();
    }

    /**
     * @param $kategori
     * @return ResponseInterface
     */
    public function getSelectOptions($kategori): ResponseInterface
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