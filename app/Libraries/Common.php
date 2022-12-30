<?php

namespace App\Libraries;
use CodeIgniter\I18n\Time;

class Common
{
    public function dateFormat($date)
    {
        if($date == null or $date == '') {
            return null;
        }

        $time = Time::parse($date);

        return $this->StrPad($time->day) . '/' .
            $this->StrPad($time->month) . '/' .
            $time->year . ' ' .
            $this->strPad($time->hour) . ':' . $this->strPad($time->minute);
    }

    public function urlCharEncode($url)
    {
        return str_replace(
            ["+", "/", "=", " "],
            ["", "_", "", "-"],
            $url);
    }

    public function urlCharDecode($url)
    {
        return str_replace(
            ["-", "_"],
            [" ", "/"],
            $url);
    }

    public function isExist()
    {
        return [
            (object) ['Valid' => true]
        ];
    }

    private function strPad($str)
    {
        return str_pad($str, 2, "0", STR_PAD_LEFT);
    }

    public function decimalToInt($number)
    {
        return (int)$number;
    }

    public function pathAccess()
    {
        $modul_access = session()->get('priv');
        $mapped = array_map(function ($item) {
            return $item->path;
        }, $modul_access);

        return $mapped;
    }

    function url_is(string $path, string $comparePath): bool
    {
        $path        = '/' . trim(str_replace('*', '(\S)*', $path), '/ ');
        $currentPath = '/' . trim($comparePath, '/ ');

        return (bool) preg_match("|^{$path}$|", $currentPath, $matches);
    }

    public function getAccess($path = null)
    {
        if($path == null) {
            $path = uri_string(true);
        }

        $modul_access = session()->get('priv');
        $filtered = array_values( array_filter($modul_access, function ($item) use($path) {
            return $this->url_is($item->route . '*', $path);
        }) );

        if(count($filtered) == 0) {
            return null;
        }

        return $filtered[0]->access;
    }

    public function breadcrumbs($current_path)
    {
        $bc = new \App\Libraries\Breadcrumbs();

        $bc->add('Dashboard', '/');

        $modul_access = session()->get('priv');
        $filtered = array_values( array_filter($modul_access, function ($item) use ($current_path) {
            return $this->url_is($item->route.'*', $current_path);
        }) );

        if( count($filtered) > 0 ) {
            if( $filtered[0]->group_menu != null ) {
                $url = $this->urlCharEncode($filtered[0]->group_menu);
                $route = site_url('parentmodule?parent=' . $url);
                $bc->add($filtered[0]->group_menu, $route);
            }

            $bc->add($filtered[0]->nama_modul, $filtered[0]->route);
        }

        if( url_is('parentmodule') ) {
            $bc->add('Parent', '/');
        }

        return $bc->render();
    }
}