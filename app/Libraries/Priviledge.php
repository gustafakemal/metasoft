<?php

namespace App\Libraries;

/**
 * Class Priviledge
 *
 * Kelas ini HANYA Di KONSUMSI oleh kelas Filter (App/Config/Filter)
 * menyediakan fungsi-fungsi untuk menentukan path/route mana saja
 * yang boleh/tidak oleh user.
 * 
 * Pendefinisian tipe akses sendiri dilakukan di kelas AccessDefinition
 *
 */

class Priviledge
{
    private $modul;

    private $accessDefinition;

    /**
     * Routes default
     */
    private const WILDCARD_PATH = [
        'BaseController(.*)',
        '(.*)/initController',
        '/',
        'login',
        'api/common/addButton',
        'api/common/reloadExportButton',
        'api/common/dt_navigation',
        'parentmodule',
        'logout',
        'auth/verify',
        'cekmodel',
        'cekmodel/print',
        'cekmodel/getBankData',
        'cekmodel/getHasilKalkulasi/([0-9]+)/([0-9]+)/([0-9]+)/([0-9]+)',
        'cekmodel/getHasilEstimasi',
        'hasilestimasi/printdetail/([0-9]+)/([0-9]+)',
        'mxbankdata/api',
        'mxbankdata/api/([0-9]+)',
    ];

    public function __construct()
    {
        if (service('auth')->isLoggedIn()) {
            $this->modul = session()->get('priv');
        }

        $this->accessDefinition = new AccessDefinition();
    }

    /**
     * @return array
     */
    public function path(): array
    {
        $path = [];

        $routes = $this->parseFromAccessDefinition();

        for ($i = 0; $i < count($routes); $i++) {
            foreach ($routes[$i] as $key => $val) {
                $path[] = $key;
            }
        }

        return $path;
    }

    /**
     * Method ini kita gunakan saat user belum login / belum ter-autentikasi     *
     *
     * @return array
     */
    public function unAuthenticated(): array
    {
        $availableRoutes = $this->accessDefinition->availableRoutes();

        $routes = [];

        foreach ($availableRoutes as $key => $val) {
            if (!in_array($key, self::WILDCARD_PATH)) {
                $routes[] = $key;
            }
        }

        return $routes;
    }

    /**
     * Ambil route mana aja yang ngga boleh diakses
     *
     * @return array
     */
    public function restricted(): array
    {
        $availableRoutes = $this->accessDefinition->availableRoutes();

        $restricted = [];

        foreach ($availableRoutes as $key => $val) {
            if (!in_array($key, $this->path()) && !in_array($key, self::WILDCARD_PATH)) {
                $restricted[] = $key;
            }
        }

        return $restricted;
    }

    /**
     * Ambil routes mana saja yang bisa diakses dari class
     * AccessDefinition berdasar access level dari user
     *
     * @return array
     */
    public function parseFromAccessDefinition(): array
    {
        $accessRoutes = $this->accessRoutes();

        $arrayRoutes = [];

        for ($i = 0; $i < count($accessRoutes); $i++) {
            $this->accessDefinition->setRoute($accessRoutes[$i]->route);
            $this->accessDefinition->setAccessLevel($accessRoutes[$i]->access);
            $arrayRoutes[] = $this->accessDefinition->get();
        }

        return $arrayRoutes;
    }

    /**
     * Ambil masing-masing access untuk tiap-tiap modul
     *
     * @return array
     */
    public function accessRoutes(): array
    {
        $newobj = [];
        for ($i = 0; $i < count($this->modul); $i++) {
            $newobj[] = (object) [
                'route' => $this->modul[$i]->route,
                'access' => $this->modul[$i]->access,
            ];
        }

        return $newobj;
    }
}
