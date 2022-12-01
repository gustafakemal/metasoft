<?php

namespace App\Libraries;

class Menu
{
    private $modul;

    public function __construct()
    {
        $this->modul = session()->get('priv');
    }

    /**
     * @return array|mixed|null
     */
    public function get()
    {
        return $this->modul;
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     */
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

    /**
     * @param $route
     * @param $icon
     * @param $modul_name
     * @return string
     */
    private function listItem($route, $icon, $modul_name): string
    {
        $active_class = $route && url_is($route) ? 'active' : '';
        return '<li class="' . $active_class . '">' .
            '<a href="' . site_url($route ?? '/') . '">' .
            $this->icon($icon) .
            $this->caption($modul_name).
            '</a>' .
            '</li>';
    }

    /**
     * @param $group_menu
     * @param $route
     * @param $icon
     * @param $modul_name
     * @return string
     */
    private function listItemDropdown($group_menu, $route, $icon, $modul_name): string
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

        $grup_icon = $this->getGroupMenuIcon($group_menu);

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

    /**
     * @param $group_menu
     * @return bool
     */
    private function urlInsideDropdown($group_menu): bool
    {
        $current_url = uri_string(true);
        $filtered = array_filter($this->modul, function ($item) use ($group_menu, $current_url) {
            return $item->group_menu === $group_menu && $item->route === $current_url;
        });

        return count($filtered) > 0;
    }

    /**
     * @param $group_menu
     * @return array|mixed|null
     */
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

    /**
     * @param $grup_menu
     * @return string
     */
    private function getGroupMenuIcon($grup_menu): string
    {
        $filtered = array_values( array_filter($this->modul, function ($item) use ($grup_menu) {
            return $item->group_menu === $grup_menu && $item->icon !== null;
        }) );

        if(count($filtered) == 0) return 'fas fa-home';

        return $filtered[0]->icon;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $body = '<ul class="main-menu accordion" id="mainmenu">';

        return $body .
            $this->dashboard() .
            $this->items() .
            $this->logout() .
            '</ul>';
    }

    /**
     * @param $icon
     * @return string
     */
    private function icon($icon = null): string
    {
        if( ! $icon ) {
            return '<div class="icon"><i class="fas fa-home"></i></div>';
        }

        return '<div class="icon"><i class="' . $icon . '"></i></div>';
    }

    /**
     * @param $caption
     * @return string
     */
    private function caption($caption): string
    {
        return '<div class="caption">' . $caption . '</div>';
    }

    /**
     * @return string
     */
    private function dashboard(): string
    {
        $active_class = (url_is(base_url()) || url_is('home') || url_is('')) ? 'active' : '';
        return '<li class="' . $active_class . '">' .
            '<a href="' . site_url() . '">' .
            $this->icon('fas fa-home') .
            $this->caption('Dashboard') .
            '</a>' .
            '</li>';
    }

    /**
     * @return string
     */
    private function logout(): string
    {
        return '<li>' .
            '<a href="' . site_url('logout') . '" onclick="return confirm(\'Anda yakin untuk Logout?\')">' .
            $this->icon('fas fa-users') .
            $this->caption('Logout') .
            '</a>' .
            '</li>';
    }
}