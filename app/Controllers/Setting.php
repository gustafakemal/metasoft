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
            $edit = '<a data-id="' . $value->id . '" class="btn btn-success btn-sm item-edit mr-1" href="#" title="Edit"><i class="far fa-edit"></i></a>';
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

    public function apiGetModulById() {}

    public function apiAddModul()
    {
        $request = $this->request->getPost();

        unset($request['id']);

        $this->model->setTable('MF_Modul');
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

        if($this->model->insert($request)) {
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

    public function apiGetAccessRight()
    {
        $query = (new \App\Models\UsersModel())->getAll();

        $data = [];
        foreach ($query as $key => $value) {

            $detail = '<a class="btn btn-primary btn-block btn-sm user-access" href="#" data-uid="' . $value->UserID . '" data-nama="' . $value->Nama . '" title="Hak Akses"><i class="fas fa-lock"></i> set akses</a>';

            $data[] = [
                $key + 1,
                $value->UserID,
                $value->Nama,
                $value->NIK,
                $detail
            ];
        }

        return $this->response->setJSON($data);
    }

    public function modulAccess($UserID)
    {
        $query = $this->model->getModul();

        $data = [];
        foreach ($query->getResult() as $key => $value) {

            $access = $this->model->modulAccess($value->id, $UserID);

            $prop1 = $UserID . '_' . $value->id.'_1';
            $prop2 = $UserID . '_' . $value->id.'_2';
            $prop3 = $UserID . '_' . $value->id.'_3';

            switch($access) {
                case 3:
                    $read = $this->checkbox($prop1, false);
                    $readWrite = $this->checkbox($prop2, false);
                    $rwd = $this->checkbox($prop3, true);
                    break;
                case 2:
                    $read = $this->checkbox($prop1, false);
                    $readWrite = $this->checkbox($prop2, true);
                    $rwd = $this->checkbox($prop3, false);
                    break;
                case 1:
                    $read = $this->checkbox($prop1, true);
                    $readWrite = $this->checkbox($prop2, false);
                    $rwd = $this->checkbox($prop3, false);
                    break;
                default:
                    $read = $this->checkbox($prop1, false);
                    $readWrite = $this->checkbox($prop2, false);
                    $rwd = $this->checkbox($prop3, false);
                    break;
            }

            $data[] = [
                $key + 1,
                $value->nama_modul,
                $read,
                $readWrite,
                $rwd,
                [$UserID, $value->id, $access]
            ];
        }

        return $this->response->setJSON($data);
    }

    private function checkbox($prop, $checked = false)
    {
        $checked = $checked ? ' checked' : '';
        $checkbox = '<input name="' . $prop . '" value="' . $prop . '" type="checkbox"' . $checked . ' class="custom-control-input access_check" id="accessCheck_' . $prop . '"/>';
        $label = '<label class="custom-control-label" for="accessCheck_' . $prop . '"></label>';
        return '<div class="custom-control custom-checkbox">' . $checkbox . $label . '</div>';
    }

    public function updateAccess()
    {
        $request = $this->request->getPost();
//        [$uid, $modul, $access, $checked] = $request;
        $modul = $request['modul'];
        $uid = $request['uid'];
        $access = $request['access'];
        $checked = $request['checked'];

        $query = $this->model->getAccess($uid, $modul);

        if( $checked == 1) {
            if($query->getNumRows() == 0) {
                $insertAccess = $this->model->insertAccess([
                    'nik' => $uid,
                    'modul' => $modul,
                    'access' => $access,
                ]);
                return $this->response->setJSON([
                    'success' => $insertAccess,
                ]);
            }

            if( $query->getNumRows() > 0 ) {
                $updateAccess = $this->model->updateAccess($uid, $modul, [
                    'access' => $access,
                ]);
                return $this->response->setJSON([
                    'success' => $updateAccess,
                ]);
            }
        } else {

            if( $access > 1 ) {
                $access -= 1;
                $updateAccess = $this->model->updateAccess($uid, $modul, [
                    'access' => $access,
                ]);
                return $this->response->setJSON([
                    'success' => $updateAccess,
                ]);
            } else {
                $deleteAccess = $this->model->deleteAccess($uid, $modul);
                return $this->response->setJSON([
                    'success' => $deleteAccess,
                ]);
            }

        }
    }
}