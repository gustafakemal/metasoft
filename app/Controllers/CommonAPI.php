<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class CommonAPI extends ResourceController
{
    private $navigation;

    public function __construct()
    {
        $this->navigation = new \App\Libraries\Navigation();
    }

    public function addButton()
    {
        return $this->response->setJSON([
            'success' => true,
            'data' => $this->navigation->button('add'),
        ]);
    }

    public function reloadExportButton()
    {
        return $this->response->setJSON([
            'success' => true,
            'data' => $this->navigation->reloadExportButton()
        ]);
    }
}