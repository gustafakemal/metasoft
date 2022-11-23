<?php

namespace App\Libraries;

class Priviledge
{
    private $modul;

    private $accessDefinition;

    private const WILDCARD_PATH = [
        'BaseController(.*)',
        '(.*)/initController',
        '/',
        'login',
        'logout',
        'auth/verify'
    ];

    public function __construct()
    {
        $this->modul = session()->get('priv');

        $this->accessDefinition = new AccessDefinition();
    }

    public function path()
    {
        $path = [];

        $routes = $this->parseFromAccessDefinition();

        for($i = 0;$i < count($routes);$i++) {

            foreach ($routes[$i] as $key => $val) {
                $path[] = $key;
            }
        }

        return $path;
    }

    public function resticted()
    {
        $availableRoutes = $this->accessDefinition->availableRoutes();

        $restricted = [];

        foreach ($availableRoutes as $key => $val) {
            if( ! in_array($key, $this->path()) && ! in_array($key, self::WILDCARD_PATH) ) {
                $restricted[] = $key;
            }
        }

        return $restricted;
    }

    public function parseFromAccessDefinition()
    {
        $accessRoutes = $this->accessRoutes();

        $arrayRoutes = [];

        for($i = 0;$i < count($accessRoutes);$i++) {
            $this->accessDefinition->setRoute($accessRoutes[$i]->route);
            $this->accessDefinition->setAccessLevel($accessRoutes[$i]->access);
            $arrayRoutes[] = $this->accessDefinition->get();
        }

        return $arrayRoutes;
    }

    public function accessRoutes()
    {
        $newobj = [];
        for($i = 0;$i < count($this->modul);$i++) {
            $newobj[] = (object) [
                'route' => $this->modul[$i]->route,
                'access' => $this->modul[$i]->access,
            ];
        }

        return $newobj;
    }
}