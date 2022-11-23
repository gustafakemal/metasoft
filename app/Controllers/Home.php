<?php

namespace App\Controllers;

use Config\Services;

class Home extends BaseController
{
    /**
     * @return string
     */
    public function index(): string
    {
        $this->breadcrumbs->add('Dashbor', '/');

        return view('Home/main', [
        	'page_title' => 'Dashbor',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render()
        ]);
    }
}