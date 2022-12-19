<?php

namespace App\Controllers;

class CommonAPI extends BaseController
{
    private $navigation;

    public function __construct()
    {
        $this->navigation = new \App\Libraries\Navigation();
    }

    public function addButton()
    {
        $uri = $this->request->getGet('url');
        $access = $this->common->getAccess($uri);
        $this->navigation->setAccess($access);
        return $this->response->setJSON([
            'success' => true,
            'data' => $this->navigation->button('add'),
        ]);
    }

    public function reloadExportButton()
    {
        $uri = $this->request->getGet('url');
        $access = $this->common->getAccess($uri);
        $this->navigation->setAccess($access);
        return $this->response->setJSON([
            'success' => true,
            'data' => $this->navigation->reloadExportButton()
        ]);
    }
}