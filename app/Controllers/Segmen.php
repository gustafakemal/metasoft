<?php

namespace App\Controllers;

class Segmen extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\SegmenModel();
    }

    public function apiGetAll()
    {
        $query = $this->model->getAll();

        return $this->response->setJSON([
            'success' => true,
            'data' => $query
        ]);
    }

    public function getSelectOptions()
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