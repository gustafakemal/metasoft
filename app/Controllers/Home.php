<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('Home/main', [
        	'page_title' => 'Dashbor',
        ]);
    }
}