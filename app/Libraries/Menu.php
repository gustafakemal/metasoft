<?php

namespace App\Libraries;

class Menu
{
    private $modul;
    private $db;

    public function __construct()
    {
        $this->modul = session()->get('priv');
        $this->db = \Config\Database::connect();
    }

    public function get()
    {
        return $this->modul;
    }

    public function rootLevel()
    {
        $root = [];
        $trackers = [];
        for($i = 0;$i < count($this->modul);$i++) {
            if( $this->modul[$i]->group_menu == null || ! in_array($this->modul[$i]->group_menu, $trackers) ) {

                $trackers[] = ($this->modul[$i]->group_menu == null) ? $this->modul[$i]->nama_modul : $this->modul[$i]->group_menu;

                $root[] = (object) [
                    'access' => $this->modul[$i]->access,
                    'nama_modul' => ($this->modul[$i]->group_menu == null) ? $this->modul[$i]->nama_modul : $this->modul[$i]->group_menu,
                    'icon' => ($this->modul[$i]->icon !== null) ? $this->modul[$i]->icon : 'fas fa-home',
                    'route' => ($this->modul[$i]->group_menu == null) ? $this->modul[$i]->route : null,
                ];
            }
        }

        return $root;
    }

    public function items()
    {
        $items = [];
        foreach ($this->rootLevel() as $menu) {
            if ($menu->route != null) {
                $item = $this->listItem($menu->route, $menu->icon, $menu->nama_modul);
            } else {
                $item = $this->listItemDropdown($menu->nama_modul, $menu->route, $menu->icon, $menu->nama_modul);
            }
            $items[] = $item;
        }

        return implode('', $items);
    }

    private function listItem($route, $icon, $modul_name)
    {
        $active_class = $route && url_is($route) ? 'active' : '';
        return '<li class="' . $active_class . '">' .
            '<a href="' . site_url($route ?? '/') . '">' .
            $this->icon($icon) .
            $this->caption($modul_name).
            '</a>' .
            '</li>';
    }

    private function listItemDropdown($group_menu, $route, $icon, $modul_name)
    {
        $collapsed = $this->urlInsideDropdown($group_menu) ? '' : 'collapsed';
        $aria_expanded = $this->urlInsideDropdown($group_menu) ? 'true' : 'false';
        $dropdown_show = $this->urlInsideDropdown($group_menu) ? ' show' : '';

        $data_target = "dropdown-" . str_replace(' ', '', $modul_name);

        $children = [];
        foreach ($this->child($group_menu) as $key => $item) {
            $namamodul = '<i class="fas fa-arrow-circle-right text-dark"></i> ' . $item->nama_modul;
            $children[] = $this->childItem($item->route, $namamodul);
        }

        $grup_icon = $this->getGrupMenuIcon($group_menu);

        return '<li>' .
            '<a class="' . $collapsed . '" href="#" data-toggle="collapse" data-target="#' . $data_target . '"
               aria-expanded="' . $aria_expanded . '">' .
            $this->icon($grup_icon) .
            $this->caption($modul_name).
            '</a>' .
            '<div id="' . $data_target . '" class="collapse' . $dropdown_show . '" data-parent="#mainmenu">' .
            '<ul class="">' .
            implode('', $children) .
            '</ul>' .
            '</div>' .
            '</li>';
    }

    private function allRouteDropdown($group_menu)
    {
        $routes = [];
        $query = $this->db->query("select route from MF_Modul where group_menu='" . $group_menu . "'");
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $item) {
                $routes[] = $item->route;
            }
        }

        return $routes;
    }

    private function urlInsideDropdown($group_menu)
    {
        return in_array(uri_string(true), $this->allRouteDropdown($group_menu));
    }

    public function child($group_menu)
    {
        return array_filter($this->modul, function ($item) use ($group_menu) {
            return $item->group_menu == $group_menu;
        });
    }

    private function childItem($route, $modul_name)
    {
        $active_class = (url_is($route)) ? 'active' : '';
        return '<li class="' . $active_class .'"><a href="' . site_url($route ?? '/') . '">' . $modul_name . '</a></li>';
    }

    private function getGrupMenuIcon($grup_menu)
    {
        $icon = null;
        $query = $this->db->query("select icon from MF_Modul where group_menu='" . $grup_menu . "'");
        foreach ($query->getResult() as $row) {
            if( $row->icon != null || $row->icon != '') {
                $icon = $row->icon;
                break;
            }
        }

        if($icon == null) {
            $icon = 'fas fa-home';
        }

        return $icon;
    }

    public function render()
    {
        $body = '<ul class="main-menu accordion" id="mainmenu">';

        return $body .
            $this->dashboard() .
            $this->items() .
            $this->logout() .
            '</ul>';
    }

    public function body()
    {
        $body = '<ul class="main-menu accordion" id="mainmenu">';
    }

    private function icon($icon = null)
    {
        if( ! $icon ) {
            return '<div class="icon"><i class="fas fa-home"></i></div>';
        }

        return '<div class="icon"><i class="' . $icon . '"></i></div>';
    }

    private function caption($caption)
    {
        return '<div class="caption">' . $caption . '</div>';
    }

//    private function parent()
//    {
//        return array_filter($this->priviledges, function ($item) {
//            return $item->parent == 0;
//        });
//    }

    private function isNested($id_prop)
    {
        $priv_mapped = array_map(function ($item) {
            return $item->parent;
        }, $this->modul);

        return in_array($id_prop, $priv_mapped);
    }

    private function dashboard()
    {
        $active_class = (url_is(base_url()) || url_is('home') || url_is('')) ? 'active' : '';
        return '<li class="' . $active_class . '">' .
            '<a href="' . site_url() . '">' .
            $this->icon('fas fa-home') .
            $this->caption('Dashboard') .
            '</a>' .
            '</li>';
    }

    private function logout()
    {
        return '<li>' .
            '<a href="' . site_url('logout') . '" onclick="return confirm(\'Anda yakin untuk Logout?\')">' .
            $this->icon('fas fa-users') .
            $this->caption('Logout') .
            '</a>' .
            '</li>';
    }
}