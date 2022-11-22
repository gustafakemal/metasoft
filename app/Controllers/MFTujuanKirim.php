<?php

namespace App\Controllers;

use App\Models\MFTujuanKirimModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class MFTujuanKirim extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new MFTujuanKirimModel();
	}

    /**
     * @return string
     */
    public function index(): string
	{
		$this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Data Tujuan Kirim', '/mftujuankirim');

		return view('MFTujuanKirim/main', [
			'page_title' => 'Data Tujuan Kirim',
			'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render()
		]);
	}

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint GET /api/master/destination
     */
    public function apiGetAll(): ResponseInterface
	{
		$query = $this->model->getMFTujuanKirim();

		$data = [];
		foreach ($query as $key => $value) {
			$CreateDate = (Time::parse($value->added))->toDateTimeString();

			$detail = '<a class="btn btn-primary btn-sm item-detail mr-1" href="#" data-id="' . $value->id . '" title="Detail"><i class="far fa-file-alt"></i></a>';
			$edit = '<a class="btn btn-success btn-sm item-edit mr-1" href="#" data-id="' . $value->id . '" data-tujuan="'.$value->tujuan.'" data-harga="'.$value->harga.'" data-added="'.$CreateDate.'" data-aktif="'.$value->aktif.'|Y,T" title="Edit"><i class="far fa-edit"></i></a>';
			$hapus = '<a class="btn btn-danger btn-sm" href="' . site_url('mftujuankirim/delete/' . $value->id) . '" data-id="' . $value->id . '" onclick="return confirm(\'Apa Anda yakin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
		
			$CreateDate = (Time::parse($value->added))->toDateTimeString();
			$data[] = [
				$key + 1,
				$value->id,
                $this->common->dateFormat($CreateDate),
				$value->tujuan,
				number_format($value->harga,2,",","."),
				$value->aktif,
                $this->common->dateFormat($value->added),
				$value->added_by,
                $this->common->dateFormat($value->updated),
				$value->updated_by,
				$detail . $edit . $hapus
			];
		}

		return $this->response->setJSON($data);
	}

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint GET /api/master/destination/$1
     */
    public function apiGetById($id): ResponseInterface
	{
		$modified = $this->request->getGet('modified') == 'yes';

		$query = $this->model->getById($id);

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
				'data' => $data
			];
		} else {
			$response = [
				'success' => false,
				'data' => null
			];
		}

		return $this->response->setJSON($response);
	}

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint POST /api/master/destination
     */
    public function apiAddProcess(): ResponseInterface
	{
		$data = $this->request->getPost();
		$data['added_by'] = current_user()->UserID;

		if ($this->model->insert($data)) {
			$msg = 'Data berhasil ditambahkan';
			session()->setFlashData('success', $msg);
			$response = [
				'success' => true,
				'msg' => $msg,
				'data' => [
					'id' => $this->model->insertID(),
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
     * Endpoint PUT /api/master/destination
     */
    public function apiEditProcess(): ResponseInterface
	{
        $data = $this->request->getRawInput();

		$data['updated_by'] = current_user()->UserID;
		$id=$data["id"];
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

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
	{
		if ($this->model->deleteById($id)) {
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
        $query = $this->model->getMFTujuanKirim();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->tujuan
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}
