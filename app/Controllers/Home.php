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

        $menu = new \App\Libraries\Menu();

        return view('Home/main', [
            'main_menu' => $menu->render(),
        	'page_title' => 'Dashbor',
            'breadcrumbs' => $this->breadcrumbs->render(),
        ]);
    }
}