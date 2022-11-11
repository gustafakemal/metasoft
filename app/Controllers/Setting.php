<?php

namespace App\Controllers;

class Setting extends BaseController
{
    public function modul()
    {
        $this->breadcrumbs->add('Setting', '/');

        $this->views['page_title'] = 'Modul';
        $this->views['breadcrumbs'] = $this->breadcrumbs->render();

        return view('Setting/modul', $this->views);
    }

    public function apiGetParent()
    {
        $db = db_connect();
        $table = $db->table('MF_ModulDef');
        $query = $table->db()->query('select * from MF_ModulDef');
        $data = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $row) {
                $data[] = [
                    1,
                    $row->display,
                    $row->route,
                    $row->dependant_routes,
                    '',
                    '',
                ];
            }
        }

        return $this->response->setJSON($data);
    }

    public function routes()
    {
        $this->breadcrumbs->add('Setting', '/');

        $this->views['page_title'] = 'Routes';
        $this->views['breadcrumbs'] = $this->breadcrumbs->render();

        return view('Setting/routes', $this->views);
    }

    public function apiGetRoutes()
    {
        $db = db_connect();
        $table = $db->table('MF_ModulRoutes');
        $query = $table->db()->query('select * from MF_ModulRoutes');
        $data = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $row) {
                $data[] = [
                    1,
                    $row->name,
                    $row->method,
                    $row->path,
                    $row->src,
                    '',
                ];
            }
        }

        return $this->response->setJSON($data);
    }
}