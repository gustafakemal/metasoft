<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * @return string
     */
    public function index(): string
    {
        //dd(session()->get('priv'));
    	$this->breadcrumbs->add('Dashbor', '/');

        $this->views['page_title'] = 'Dashboard';
        $this->views['breadcrumbs'] = $this->breadcrumbs->render();

        return view('Home/main', $this->views);
    }
}