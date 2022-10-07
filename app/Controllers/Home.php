<?php

namespace App\Controllers;

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
        ]);
    }
}