<?php

namespace App\Libraries;

use Config\Services;

class AccessDefinition
{
    private $modul_name;
    private $access_level;

    private const READ = '/(^%s$|^%s\/api)/';
    private const WRITE = '/(^%1$s\/add|^%2$s\/edit)/';

    public function __construct(string $modul_name, int $access_level)
    {
        $this->modul_name = $modul_name;
        $this->access_level = $access_level;
    }

    public function formula()
    {

    }

    public function availableRoutes()
    {
        $routes = Services::Routes();
        $post = $routes->getRoutes('post');
        $get = $routes->getRoutes('get');
        $put = $routes->getRoutes('put');
        $delete = $routes->getRoutes('delete');

        return array_merge($post, $get, $put, $delete);
    }

    public function modulRoutes()
    {
        $modul_name = $this->modul_name;
        return array_filter($this->availableRoutes(), function ($item) use ($modul_name) {
            return preg_match('/^' . $modul_name . '/', $item);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function read()
    {
        return $this->filter('/(^' . $this->modul_name . '$|^' . $this->modul_name . '\/api)/');
    }

    public function write()
    {
        $pattern = sprintf(self::WRITE, $this->modul_name, $this->modul_name);
        return $this->filter($pattern);
    }

    public function delete()
    {
        return $this->filter('/^' . $this->modul_name . '\/delete)/');
    }

    public function filter($pattern)
    {
        return array_filter($this->availableRoutes(), function ($item) use ($pattern) {
            return preg_match($pattern, $item);
        }, ARRAY_FILTER_USE_KEY);
    }
}