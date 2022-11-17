<?php

namespace App\Controllers;

use App\Models\SettingModel;

class Setting extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new SettingModel();
    }
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
        $query = $this->model->getModul();

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

    public function apiAddModul()
    {
        $request = $this->request->getPost();

        unset($request['id']);

        $tbl = $this->model->setModulTbl();
        $this->model->setAllowedFields(['nama_modul', 'route', 'icon', 'group_menu']);

        $rules = [
            'nama_modul' => 'required',
            'route' => 'required'
        ];
        $this->model->setValidationRules($rules);
        $messages = [
            'nama_modul' => [
                'required' => 'Nama modul wajib diisi'
            ],
            'route' => [
                'required' => 'Route wajib diisi'
            ]
        ];
        $this->model->setValidationMessages($messages);

        if($tbl->insert($request)) {
            $response = [
                'success' => true,
                'msg' => 'Modul ' . $request['nama_modul'] . ' berhasil ditambahkan.'
            ];
        } else {
               $response = [
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>'
            ];
        }

        return $this->response->setJSON($response);
    }

    public function accessRight()
    {
        $this->breadcrumbs->add('Dashbor', '/');

        return view('Setting/accessright', [
            'page_title' => 'Hak Akses',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render()
        ]);
    }
}