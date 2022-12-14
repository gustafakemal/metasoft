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
    private const READ = '/(^%s$|^%s\/api|^%s\/rev|^%s\/detail)/';

    /**
     * WRITE access pattern
     */
    private const WRITE = '/(^%1$s\/add|^%2$s\/edit|^%2$s\/set)/';

    /**
     * DELETE access pattern
     */
    private const DELETE = '/^%1$s\/delete/';

//    public function __construct(string $route, int $access_level)
//    {
//        $this->route = $route;
//        $this->access_level = $access_level;
//    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->formula();
    }

    /**
     * Listing existing routes in the app
     *
     * @return array
     */
    public function availableRoutes(): array
    {
        $routes = Services::Routes();
        $post = $routes->getRoutes('post');
        $get = $routes->getRoutes('get');
        $put = $routes->getRoutes('put');
        $delete = $routes->getRoutes('delete');

        return array_merge($post, $get, $put, $delete);
    }

    public function modulRoutes(): array
    {
        $pattern = '/^' . $this->route . '/';
        return $this->filter($pattern);
    }

    /**
     * Get all routes within READ access
     *
     * @return array
     */
    public function read(): array
    {
        $pattern = sprintf(self::READ, $this->route, $this->route, $this->route, $this->route);
        return $this->filter($pattern);
    }

    /**
     * Get all routes within WRITE access
     *
     * @return array
     */
    public function write(): array
    {
        $pattern = sprintf(self::WRITE, $this->route, $this->route);
        return $this->filter($pattern);
    }

    /**
     * Get all routes within DELETE access
     *
     * @return array
     */
    public function delete(): array
    {
        $pattern = sprintf(self::DELETE, $this->route);
        return $this->filter($pattern);
    }

    /**
     * Level akses beserta otorisasinya
     *
     * @return array
     */
    private function formula(): array
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

    /**
     * Ambil dan parsing key dari array routes
     *
     * @param $pattern
     * @return array
     */
    private function filter($pattern): array
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
        $pattern = str_replace('/', '\/', $route);
        $this->route = $pattern;
    }

    /**
     * @param mixed $access_level
     */
    public function setAccessLevel($access_level): void
    {
        $this->access_level = $access_level;
    }
}