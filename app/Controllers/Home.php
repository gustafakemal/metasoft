<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
    	$this->breadcrumbs->add('Dashbor', '/');

        return view('Home/main', [
        	'page_title' => 'Dashbor',
            'breadcrumbs' => $this->breadcrumbs->render(),
        ]);
    }
}