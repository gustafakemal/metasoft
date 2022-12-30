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
        return view('Home/main', [
        	'page_title' => 'Dashbor',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render()
        ]);
    }

    public function parentModule()
    {
        $parent = $this->common->urlCharDecode($this->request->getGet('parent'));

        $sess = session()->get('priv');

        $mapped = array_filter( array_map(function ($item) use ($parent) {
            if( trim($item->group_menu) == trim($parent) ) {
                return (object) [
                    'nama_modul' => $item->nama_modul,
                    'route' => $item->route
                ];
            }
        }, $sess), function ($item) {
            return $item != null;
        });

        return view('Home/parent_module', [
            'page_title' => $parent,
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'moduls' => $mapped
        ]);
    }
}