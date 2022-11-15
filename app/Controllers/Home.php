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
        //dd(Services::Routes()->getRoutes('edit'));

        $def = new \App\Libraries\AccessDefinition('pelanggan', 3);
//        $filt = array_filter($def->availableRoutes(), function ($item) {
//            return preg_match('/(^pelanggan\/add|^pelanggan\/edit)/', $item);
//        }, ARRAY_FILTER_USE_KEY);
        dd($def->write());

    	$this->breadcrumbs->add('Dashbor', '/');

        return view('Home/main', [
        	'page_title' => 'Dashbor',
            'breadcrumbs' => $this->breadcrumbs->render(),
        ]);
    }
}