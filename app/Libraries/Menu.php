<?php

namespace App\Libraries;

class Menu
{
    private $modul;

    public function __construct()
    {
        $this->modul = session()->get('priv');
    }

    public function get()
    {
        return $this->modul;
    }
}