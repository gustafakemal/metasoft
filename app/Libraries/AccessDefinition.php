<?php

namespace App\Libraries;

use Config\Services;

class AccessDefinition
{
    private $route;
    private $access_level;

    /**
     * READ access pattern
     */
    private const READ = '/(^%s$|^%s\/api)/';

    /**
     * WRITE access pattern
     */
    private const WRITE = '/(^%1$s\/add|^%2$s\/edit)/';

    /**
     * DELETE access pattern
     */
    private const DELETE = '/^%1$s\/delete/';

//    public function __construct(string $route, int $access_level)
//    {
//        $this->route = $route;
//        $this->access_level = $access_level;
//    }

    public function get()
    {
        return $this->formula();
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
        $pattern = '/^' . $this->route . '/';
        return $this->filter($pattern);
    }

    public function read()
    {
        $pattern = sprintf(self::READ, $this->route, $this->route);
        return $this->filter($pattern);
    }

    public function write()
    {
        $pattern = sprintf(self::WRITE, $this->route, $this->route);
        return $this->filter($pattern);
    }

    public function delete()
    {
        $pattern = sprintf(self::DELETE, $this->route);
        return $this->filter($pattern);
    }

    private function formula()
    {
        switch ($this->access_level) {
            case 1:
                $user_access = $this->read();
                break;
            case 2:
                $user_access = array_merge($this->read(), $this->write());
                break;
            case 3:
                $user_access = array_merge($this->read(), $this->write(), $this->delete());
                break;
            default:
                $user_access = [];
                break;
        }

        return $user_access;
    }

    private function filter($pattern)
    {
        return array_filter($this->availableRoutes(), function ($item) use ($pattern) {
            return preg_match($pattern, $item);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route): void
    {
        $this->route = $route;
    }

    /**
     * @param mixed $access_level
     */
    public function setAccessLevel($access_level): void
    {
        $this->access_level = $access_level;
    }
}