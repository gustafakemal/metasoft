<?php

namespace App\Libraries;

class Priviledge
{
    private $modul;

    public function __construct()
    {
        $this->modul = session()->get('priv');
    }

    public function accessRoutes()
    {

    }
}