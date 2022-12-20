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
        $access = $this->common->getAccess(uri_string(true));
        $navigation = new \App\Libraries\Navigation();
        $navigation->setAccess($access);

        $query = $this->model->getModul();

        $data = [];
        foreach ($query->getResult() as $key => $value) {

            $detail = $navigation->button('detail', [
                'data-id' => $value->id,
            ]);
            $set_access = $navigation->customButton('<i class="fas fa-lock"></i>', [
                'class' => 'btn btn-info btn-sm set-user-access mr-1',
                'title' => 'Set Akses',
                'data-id' => $value->id,
            ]);
            $edit = $navigation->button('edit', [
                'data-id' => $value->id,
            ]);
            $hapus = $navigation->button('delete', [
                'href' => site_url('setting/modul/delete/' . $value->id),
            ]);

            $data[] = [
                $key + 1,
                $value->nama_modul,
                $value->route,
                $value->icon,
                $value->group_menu,
                $detail . $set_access . $edit . $hapus
            ];
        }

        return $this->response->setJSON($data);
    }

    public function apiGetModulById($id)
    {
        $query = $this->model->getModulById($id);

        if($query->getNumRows() > 0) {
            $response = [
                'success' => true,
                'data' => $query->getResult()[0]
            ];
        } else {
            $response = [
                'success' => false,
                'data' => []
            ];
        }

        return $this->response->setJSON($response);
    }

    public function apiDeleteModul($id)
    {
        if ($this->model->deleteModulById($id)) {
            return redirect()->back()
                ->with('success', 'Data berhasil dihapus');
        }

        return redirect()->back()
            ->with('error', 'Data gagal dihapus');
    }

    public function apiGetUsers($mod_id)
    {
        $query = (new \App\Models\UsersModel())->getAll();
        $query2 = (new \App\Models\UsersModel())->getUsersAndAccess($mod_id);
        $query_access = $this->model->getAccessByModul($mod_id);

        if($query_access->getNumRows() > 0) {
            $users_access = array_map(function ($item) {
                unset($item->id);
                unset($item->modul);
                return $item;
            }, $query_access->getResult());
        } else {
            $users_access = [];
        }

        $data = [];
        foreach ($query as $key => $value) {

            if($query_access->getNumRows() > 0) {
                $access = array_values( array_filter($query_access->getResult(), function ($item) use ($value) {
                    return $item->nik == $value->UserID;
                }) );
                if(count($access) > 0) {
                    $access = $access[0]->access;
                } else {
                    $access = 0;
                }
            } else {
                $access = 0;
            }

            $detail = '<select name="access" class="custom-select custom-select-sm">' .
                '<option value=""' . (($access == 0) ? " selected" : "") . '>-No Access-</option>' .
                '<option value="1"' . (($access == 1) ? " selected" : "") . '>R (Read)</option>' .
                '<option value="2"' . (($access == 2) ? " selected" : "") . '>R/W (Read/Write)</option>' .
                '<option value="3"' . (($access == 3) ? " selected" : "") . '>R/W/D (Read/Write/Delete)</option>';

            $data[] = [
                $key + 1,
                $value->UserID,
                $value->Nama,
                $value->NIK,
                $detail,
            ];
        }

        return $this->response->setJSON($data);
    }

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

    public function apiEditModul()
    {
        $request = $this->request->getPost();

        $id = (int)$request['id'];
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

        if($this->model->update($id, $request)) {
            $response = [
                'success' => true,
                'msg' => 'Modul ' . $request['nama_modul'] . ' berhasil diupdate.'
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