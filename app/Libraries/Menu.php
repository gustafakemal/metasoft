<?php

namespace App\Libraries;

class Menu
{
    private $priviledges;

    public function __construct()
    {
        $this->priviledges = session()->get('priv');
    }

    public function render()
    {
        $body = '<ul class="main-menu accordion" id="mainmenu">';

        return $body .
            $this->dashboard() .
            $this->items() .
            $this->setting() .
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

    private function listItem($path, $icon, $display)
    {
        $active_class = $path && url_is($path) ? 'active' : '';
        return '<li class="' . $active_class . '">' .
            '<a href="' . site_url($path ?? '/') . '">' .
            $this->icon($icon) .
            $this->caption($display).
            '</a>' .
            '</li>';
    }

    private function listItemDropdown($id, $path, $icon, $display)
    {
        $collapsed = $path && url_is($path) ? '' : 'collapsed';
        $aria_expanded = $path && url_is($path) ? 'true' : 'false';
        $dropdown_show = $path && (url_is($path) || url_is($path . '/*')) ? ' show' : '';

        $children = [];
        foreach ($this->child($id) as $item) {
            array_push($children, $this->childItem($item->path, $item->display));
        }

        return '<li>' .
            '<a class="' . $collapsed . '" href="#" data-toggle="collapse" data-target="#dropdown-mf"
               aria-expanded="' . $aria_expanded . '">' .
            $this->icon($icon) .
            $this->caption($display).
            '</a>' .
            '<div id="dropdown-mf" class="collapse' . $dropdown_show . '" data-parent="#mainmenu">' .
            '<ul class="">' .
            implode('', $children) .
            '</ul>' .
            '</div>' .
            '</li>';
    }

    private function childItem($path, $display)
    {
        $active_class = (url_is('mfproduk') || url_is('mfproduk/*') || url_is('MFProduk') || url_is('MFProduk/*')) ? 'active' : '';
        return '<li class="' . $active_class .'"><a href="' . site_url($path ?? '/') . '">' . $display . '</a></li>';
    }

    private function parent()
    {
        return array_filter($this->priviledges, function ($item) {
            return $item->parent == 0;
        });
    }

    private function child($id_prop)
    {
        return array_filter($this->priviledges, function ($item) use ($id_prop) {
            return $item->parent == $id_prop;
        });
    }

    private function isNested($id_prop)
    {
        $priv_mapped = array_map(function ($item) {
            return $item->parent;
        }, $this->priviledges);

        return in_array($id_prop, $priv_mapped);
    }

    public function items()
    {
        $items = [];
        foreach ($this->parent() as $menu) {
            if ($this->isNested($menu->id) == 0) {
                $item = $this->listItem($menu->path, $menu->menu_icon, $menu->display);
            } else {
                $item = $this->listItemDropdown($menu->id, $menu->path, $menu->menu_icon, $menu->display);
            }
            array_push($items, $item);
        }

        return implode('', $items);
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
            '<a href="' . site_url() . '" onclick="return confirm(\'Anda yakin untuk Logout?\')">' .
            $this->icon('fas fa-users') .
            $this->caption('Logout') .
            '</a>' .
            '</li>';
    }

    private function setting()
    {
        $collapsed = url_is('setting') ? '' : 'collapsed';
        $aria_expanded = url_is('setting') ? "true" : "false";
        $collapse_show = (url_is('setting') || url_is('setting/*')) ? ' show' : '';
        $class_active = url_is('setting') ? "active" : "";

        return '<li>' .
            '<a class="' . $collapsed . '" href="#" data-toggle="collapse" data-target="#dropdown-setting" aria-expanded="' . $aria_expanded . '">' .
            $this->icon('fas fa-cog') .
            $this->caption('Setting').
            '</a>' .
            '<div id="dropdown-setting" class="collapse' . $collapse_show . '" data-parent="#mainmenu">' .
            '<ul class="">' .
            '<li class="' . $class_active .'"><a href="' . site_url('setting/modul') . '">Modul</a></li>' .
            '<li class="' . $class_active .'"><a href="' . site_url('setting/routes') . '">Routes</a></li>' .
            '</ul>' .
            '</div>' .
            '</li>';
    }
}