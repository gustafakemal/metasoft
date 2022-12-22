<?php

namespace App\Controllers;

class CommonAPI extends BaseController
{
    private $navigation;

    public function __construct()
    {
        $this->navigation = new \App\Libraries\Navigation();
    }

    private function getPath($url)
    {
        $path_url = ltrim(str_replace(base_url(), '', $url), "/");

        return $path_url;
    }

    public function dt_navigation()
    {
        $url = $this->getPath($this->request->getPost('url'));
        $buttons = $this->request->getPost('buttons');

        $datas = [];
        foreach ($buttons as $btn) {
            switch ($btn) {
                case 'reload-export':
                    $data = $this->reloadExportButton($url);
                    break;
                case 'add':
                    $data = $this->addButton($url);
                    break;
                default:
                    $data = null;
                    break;
            }
            $datas[] = $data;
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => implode('', $datas)
        ]);
    }

    public function addButton($uri)
    {
        $access = $this->common->getAccess($uri);
        $this->navigation->setAccess($access);

        return $this->navigation->button('add');
    }

    public function reloadExportButton($uri)
    {
        $access = $this->common->getAccess($uri);
        $this->navigation->setAccess($access);

        return $this->navigation->reloadExportButton();
    }
}