<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Segmen extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\SegmenModel();
    }

    /**
     * @return ResponseInterface
     */
    public function apiGetAll(): ResponseInterface
    {
        $query = $this->model->getAll();

        return $this->response->setJSON([
            'success' => true,
            'data' => $query
        ]);
    }

    /**
     * @return ResponseInterface
     */
    public function getSelectOptions(): ResponseInterface
    {
        $query = $this->model->getAll();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => $row->OpsiVal,
                'name' => $row->OpsiTeks
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}