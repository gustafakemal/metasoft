<?php

namespace App\Libraries;

class Navigation
{
    public function button($btnType, $attr = [])
    {
        switch ($btnType) {
            case 'edit':
                $button = $this->editBtn($attr);
                break;
            case 'detail':
                $button = $this->detailBtn($attr);
                break;
            case 'delete':
                $button = $this->deleteBtn($attr);
                break;
            default:
                $button = null;
                break;
        }

        return $button;
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
}