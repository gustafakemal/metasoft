<?php

namespace App\Libraries;

class Navigation
{
    private int $id;

    private int $access;

    public function __construct()
    {
        $modul_access = session()->get('priv');
        $filtered = array_values( array_filter($modul_access, function ($item) {
            return url_is($item->route.'*');
        }) );
        $this->access = (count($filtered) > 0) ? $filtered[0]->access : 3;
    }

    public function button($btnType, $attrs = [])
    {
        switch ($btnType) {
            case 'add':
                $button = ($this->access >= 2) ? $this->addBtn('Tambah Data', $attrs) : null;
                break;
            case 'edit':
                $button = ($this->access >= 2) ? $this->editBtn($attrs) : null;
                break;
            case 'detail':
                $button = ($this->access >= 1) ? $this->detailBtn($attrs) : null;
                break;
            case 'delete':
                $button = ($this->access == 3) ? $this->deleteBtn($attrs) : null;
                break;
            default:
                $button = null;
                break;
        }

        return $button;
    }

    public function addBtn($caption, array $customAttributes): string
    {
        $attr = [
            'class' => 'btn btn-primary btn-add mr-2 add-data_btn',
            'href' => '#',
        ];

        $attrs = array_merge($attr, $customAttributes);
        $attributes = $this->parseAttributes($attrs);

        return '<a ' . $attributes . '>' . $caption . '</a>';
    }

    private function detailBtn(array $customAttributes): string
    {
        $attr = [
            'class' => 'btn btn-primary btn-sm item-detail mr-1',
            'href' => '#',
            'data-id' => 0,
            'title' => 'Detail'
        ];

        $attrs = array_merge($attr, $customAttributes);
        $attributes = $this->parseAttributes($attrs);

        return '<a ' . $attributes . '><i class="far fa-file-alt"></i></a>';
    }

    private function editBtn(array $customAttributes): string
    {
        $attr = [
            'class' => 'btn btn-success btn-sm item-edit mr-1',
            'href' => '#',
            'data-id' => 0,
            'data-nama' => '',
            'data-nik' => '',
            'data-aktif' => '',
            'title' => 'Edit'
        ];

        $attrs = array_merge($attr, $customAttributes);
        $attributes = $this->parseAttributes($attrs);

        return '<a ' . $attributes . '><i class="far fa-edit"></i></a>';
    }

    private function deleteBtn(array $customAttributes): string
    {
        $confirm = "return confirm('Apa Anda yakin menghapus data ini?')";
        $attr = [
            'class' => 'btn btn-danger btn-sm',
            'href' => '#',
            'data-id' => 0,
            'onclick' => $confirm,
            'title' => 'Hapus'
        ];

        $attrs = array_merge($attr, $customAttributes);
        $attributes = $this->parseAttributes($attrs);

        return '<a ' . $attributes . '><i class="fas fa-trash-alt"></i></a>';
    }

    private function reloadNav()
    {
        return '<a class="dropdown-item data-reload" href="#">Reload data</a>';
    }

    private function exportToCsvNav()
    {
        if($this->access < 2) {
            return null;
        }

        return '<a class="dropdown-item data-to-csv" href="#">Export to excel</a>';
    }

    public function reloadExportButton()
    {
        return '<div class="dropdown d-inline mr-2">' .
				'<button class="btn btn-primary dropdown-toggle" type="button" id="customersDropdown" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></button>' .
				'<div class="dropdown-menu" aria-labelledby="customersDropdown">' .
				$this->reloadNav() .
				$this->exportToCsvNav() .
				'</div>' .
				'</div>';
    }

    public function customButton($label, $attributes, $type = 'button')
    {
        $attribute = $this->parseAttributes($attributes);

        if($type == 'link') {
            return $this->linkType($attribute, $label);
        }

        return $this->buttonType($attribute, $label);
    }

    private function parseAttributes(array $attributes): string
    {
        $attrs = [];
        foreach ($attributes as $key => $val) {
            $attrs[] = $key . '="' . $val .'"';
        }

        return implode(' ', $attrs);
    }

    private function buttonType($attributes, $label)
    {
        return '<button ' . $attributes . '>' . $label . '</button>';
    }

    private function linkType($attributes, $label)
    {
        return '<a ' . $attributes . '>' . $label . '</a>';
    }

    /**
     * @param int $id
     */
    public function dataId(int $id)
    {
        $this->id = $id;
        return $this;
    }
}