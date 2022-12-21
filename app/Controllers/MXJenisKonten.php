<?php

namespace App\Controllers;

use App\Models\MXJenisKontenModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class MXJenisKonten extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new MXJenisKontenModel();
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Jenis Konten Metaflex', '/MXJenisKonten');

       
        return view('MXJenisKonten/main', [
            'page_title' => 'Jenis Konten Metaflex',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
        ]);
    
    }

  
    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     */
    public function apiGetAll(): ResponseInterface
    {
        $access = $this->common->getAccess(uri_string(true));
        $navigation = new \App\Libraries\Navigation();
        $navigation->setAccess($access);

        $query = $this->model->getMXJenisKonten();  
        $data = [];
        foreach ($query as $key => $value) {

            //$CreateDate = (Time::parse($value->added))->toDateTimeString();

            $detail = $navigation->button('detail', [
                'data-id' => $value->ID,
            ]);
            $edit = $navigation->button('edit', [
                'data-nama' => $value->Nama,
                'data-id' => $value->ID,
                'data-aktif' => $value->Aktif . '|Y,T',
            ]);
            $hapus = $navigation->button('delete', [
                'href' => site_url('mxjeniskonten/delete/' . $value->ID),
            ]);

            $data[] = [
                $key + 1,
                //$value->ID,
                //$this->common->dateFormat($CreateDate),
                $value->Nama,
                //number_format($value->berat_jenis, 2, ",", "."),
                //number_format($value->harga, 2, ",", "."),
                $value->Aktif,
                //$this->common->dateFormat($value->added),
                //$value->added_by,
                //$this->common->dateFormat($value->updated),
                //$value->updated_by,
                $detail . $edit . $hapus,
            ];
        }


        return $this->response->setJSON($data);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     */
    public function apiGetById($ID): ResponseInterface
    {
        $modified = $this->request->getGet('modified') == 'yes';

        $query = $this->model->getById($ID);

        if (count($query) == 1) {
            $data = $query[0];

            if ($modified) {
                $data = [];
                foreach ($query[0] as $key => $value) {
                    if ($key == 'Aktif') {
                        $data[$key] = ($value == 'Y') ? 'Aktif' : 'Nonaktif';
                    //} elseif ($key == 'added' || $key == 'updated') {
                    //    $data[$key] = ($value != null) ? (Time::parse($value))->toDateTimeString() : '-';
                    } else {
                        $data[$key] = $value ?? '-';
                    }
                }
            }

            $response = [
                'success' => true,
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'data' => null,
            ];
        }

        return $this->response->setJSON($response);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     */
    public function apiAddProcess(): ResponseInterface
    {
        $data = $this->request->getPost();
        //$data['added_by'] = current_user()->UserID;


        if ($this->model->insert($data)) {
            $msg = 'Data berhasil ditambahkan';
            session()->setFlashData('success', $msg);
            $response = [
                'success' => true,
                'msg' => $msg,
                'data' => [
                    'ID' => $this->model->insertID(),
                ],
            ];
        } else {
            $response = [
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
                'data' => null,
            ];
        }

        return $this->response->setJSON($response);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint PUT /api/master/tinta
     */
    public function apiEditProcess(): ResponseInterface
    {
        $data = $this->request->getRawInput();
       
        //dd($data);
        //$data['updated_by'] = current_user()->UserID;
        $ID= $data["ID"];
        unset($data["ID"]);

        if ($this->model->updateById($ID, $data)) {
            $msg = 'Data berhasil diupdate';
            $response = [
                'success' => true,
                'msg' => $msg,
                'data' => [
                    'ID' => $ID,
                ],
            ];
       
        } else {
            $response = [
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
                'data' => null,
            ];
          
        }

        return $this->response->setJSON($response);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($ID): RedirectResponse
    {
        if ($this->model->deleteById($ID)) {
            return redirect()->back()
                ->with('success', 'Data berhasil dihapus');
        }

        return redirect()->back()
            ->with('error', 'Data gagal dihapus');
    }

    /**
     * @return ResponseInterface
     */
    public function getSelectOptions(): ResponseInterface
    {
        $query = $this->model->getOpsi();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'ID' => $row->ID,
                'name' => $row->Nama,
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data,
        ]);
    }
}
