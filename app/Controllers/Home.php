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
        //dd(session()->get('priv'));

        //$def = new \App\Libraries\AccessDefinition('pelanggan', 1);
        //dd($def->get());

        //$priv = new \App\Libraries\Priviledge();
        //dd($priv->resticted());
        //dd($priv->get());

//        $filters = new \Config\Filters();
//        dd($filters->filters);

        $menu = new \App\Libraries\Menu();
        //dd($menu->rootLevel());



    	$this->breadcrumbs->add('Dashbor', '/');

        return view('Home/main', [
        	'page_title' => 'Dashbor',
            'breadcrumbs' => $this->breadcrumbs->render(),
        ]);
    }
}