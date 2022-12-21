<?php

namespace App\Controllers;

use Config\App;

class Form extends BaseController
{
    private $model;

    public function __construct() {
        $this->model = new \App\Models\Forms();
    }

    public function index()
    {
        return view('Forms/MXProspect', [
            'page_title' => 'Forms',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
        ]);
    }

    public function nama_halaman()
    {
        return view('Forms/nama_halaman');
    }

    public function submit_add()
    {
        $request = $this->request->getPost(''); // Masukkan nama form name

        dd($request);
    }
}