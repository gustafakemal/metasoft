<?php

namespace App\Controllers;

use App\Models\MFJenisKertasModel;
use CodeIgniter\I18n\Time;

class MFJenisKertas extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new MFJenisKertasModel();
	}

	public function index()
	{
		$this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Data Jenis Kertas MF', '/mfjeniskertas');

		return view('MFJenisKertas/main', [
			'page_title' => 'Data Jenis Kertas MF',
            'breadcrumbs' => $this->breadcrumbs->render(),
		]);
	}

	public function apiGetAll()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfjeniskertas');
		}

		$query = $this->model->getMFJenisKertas();

		$data = [];
		foreach ($query as $key => $value) {
			//$detail = '<a href="#" data-id="' . $value->id . '" class=" btn item-detail" title="Detail"><i class="far fa-file-alt"></i></a> ';
			//$edit = '<a href="#" data-id="' . $value->id . '" class="item-edit" title="Edit"><i class="far fa-edit"></i></a> ';
			//$hapus = '<a href="' . site_url('mfjeniskertas/delete/' . $value->id) . '" onclick="return confirm(\'Apa Anda yakin menghapus user ini?\')" title="Delete"><i class="fas fa-trash-alt"></i></a>';

			$CreateDate = (Time::parse($value->added))->toDateTimeString();

			$obj = [
				'CreateDate' => $CreateDate,
				'nama' => $value->nama,
				'harga' => $value->harga
			];

			$objstring = json_encode($obj);
			 
			$detail = '<a class="btn btn-primary btn-sm item-detail mr-1" href="#" data-id="' . $value->id . '" title="Detail"><i class="far fa-file-alt"></i></a>';
			$edit = '<a class="btn btn-success btn-sm item-edit mr-1" href="#" data-id="' . $value->id . '" data-nama="'.$value->nama.'" data-harga="'.$value->harga.'" data-berat="'.$value->berat.'" data-added="'.$CreateDate.'" data-aktif="'.$value->aktif.'|Y,T" title="Edit"><i class="far fa-edit"></i></a>';
			$hapus = '<a class="btn btn-danger btn-sm" href="' . site_url('mfjeniskertas/delete/' . $value->id) . '" data-id="' . $value->id . '" onclick="return confirm(\'Apa Anda yakin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
	
		
			$data[] = [
				$key + 1,
				$value->id,
				$CreateDate,
				$value->nama,
				(int)$value->berat,
				number_format($value->harga,2,",","."),
				$value->aktif,
				$value->added,
				$value->added_by,
				$value->updated,
				$value->updated_by,
				$detail . $edit . $hapus
			];
		}

		return $this->response->setJSON($data);
	}

	public function apiGetById()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfjeniskertas');
		}

		$id = $this->request->getPost('id');
		$modified = $this->request->getPost('modified') ?? false;

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

	public function apiAddProcess()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfjeniskertas');
		}

		$data = $this->request->getPost();
		//$data['id'] = $this->model->getMaxId() + 1;
		$data['added_by'] = current_user()->UserID;

		// return $this->response->setJSON($data);

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

	public function apiEditProcess()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfjeniskertas');
		}

		$data = $this->request->getPost();
		// return $this->response->setJSON($data);

		$data['updated_by'] = current_user()->UserID;
		$id = $data["id"];
		unset($data["id"]);
		// return $this->response->setJSON(['id' => $id, 'data' => $data]);
		if ($this->model->updateById($id, $data)) {
			$msg = 'Data berhasil diupdate';
			//session()->setFlashData('success', $msg);
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

	public function delete($id)
	{
		if ($this->model->deleteById($id)) {
			return redirect()->back()
				->with('success', 'Data berhasil dihapus');
		}

		return redirect()->back()
			->with('error', 'Data gagal dihapus');
	}

    public function getSelectOptions()
    {
        $query = $this->model->getMFJenisKertas();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->nama
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}
