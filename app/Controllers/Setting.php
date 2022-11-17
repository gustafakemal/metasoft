<?php

namespace App\Controllers;

class Setting extends BaseController
{
    public function modul()
    {
        $this->breadcrumbs->add('Dashbor', '/');

        return view('Setting/modul', [
            'page_title' => 'Modul',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render()
        ]);
    }

    public function apiGetModul()
    {
        $query = (new \App\Models\SettingModel())->getModul();

        $data = [];
        foreach ($query->getResult() as $key => $value) {

            $detail = '<a class="btn btn-primary btn-sm item-detail mr-1" href="#" data-id="" title="Detail"><i class="far fa-file-alt"></i></a>';
            $edit = '<a class="btn btn-success btn-sm item-edit mr-1" href="#" title="Edit"><i class="far fa-edit"></i></a>';
            $hapus = '<a class="btn btn-danger btn-sm" href="' . site_url('mfjenisflute/delete/' . $value->id) . '" data-id="' . $value->id . '" onclick="return confirm(\'Apa Anda yakin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';

            $data[] = [
                $key + 1,
                $value->nama_modul,
                $value->route,
                $value->icon,
                $value->group_menu,
                $detail . $edit . $hapus
            ];
        }

        return $this->response->setJSON($data);
    }
}