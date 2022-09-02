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
}