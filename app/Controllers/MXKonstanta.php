<?php

namespace App\Controllers;

use App\Models\MXKonstantaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class MXKonstanta extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new MXKonstantaModel();
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $queryCorrection = $this->model->getByKategori('Correction');
        $queryMargin = $this->model->getByKategori('Margin');
        $querySolidContent = $this->model->getByKategori('Solid Content');

        $data = [];
        $data[] = ['Correction', $queryCorrection];
        $data[] = ['Margin', $queryMargin];
        $data[] = ['Solid Content', $querySolidContent];
        //dd($data);

        return view('MXKonstanta/main', [
            'page_title' => 'Data Konstanta',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'time' => $this->common,
            'data' => $data,
        ]);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     */
    public function apiGetByKonstanta($konstanta): ResponseInterface
    {
        $modified = $this->request->getGet('modified') == 'yes';

        $query = $this->model->getByKonstanta($konstanta);

        if (count($query) == 1) {
            $data = $query[0];

            if ($modified) {
                $data = [];
                foreach ($query[0] as $key => $value) {
                    if ($key == 'aktif') {
                        $data[$key] = ($value == 'Y') ? 'Aktif' : 'Nonaktif';
                    } elseif ($key == 'added' || $key == 'updated') {
                        $data[$key] = ($value != null) ? (Time::parse($value))->toDateTimeString() : '-';
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
    public function apiEditProcess(): ResponseInterface
    {
        $data = $this->request->getRawInput();

        $data['updated_by'] = current_user()->UserID;
        $id = $data["id"];
        unset($data["id"]);

        if ($this->model->updateById($id, $data)) {
            $msg = 'Data berhasil diupdate';
            $response = [
                'success' => true,
                'msg' => $msg,
                'data' => [
                    'id' => $id,
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

}
