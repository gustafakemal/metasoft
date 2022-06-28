<?php

namespace App\Controllers;

use App\Models\MFTujuanKirimModel;
use CodeIgniter\I18n\Time;

class MFTujuanKirim extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new MFTujuanKirimModel();
	}

	public function index()
	{
		return view('MFTujuanKirim/main', [
			'page_title' => 'Data Tujuan Kirim',
		]);
	}

	public function apiGetAll()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mftujuankirim');
		}

		$query = $this->model->getMFTujuanKirim();

		$data = [];
		foreach ($query as $key => $value) {
			$detail = '<a class="btn btn-primary btn-sm item-detail mr-1" href="#" data-id="' . $value->id . '" title="Detail"><i class="far fa-file-alt"></i></a>';
			$edit = '<a class="btn btn-success btn-sm item-edit mr-1" href="#" data-id="' . $value->id . '" title="Edit"><i class="far fa-edit"></i></a>';
			$hapus = '<a class="btn btn-danger btn-sm" href="' . site_url('mftujuankirim/delete/' . $value->id) . '" data-id="' . $value->id . '" onclick="return confirm(\'Apa Anda yakin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
	
		
			$CreateDate = (Time::parse($value->added))->toDateTimeString();
			$data[] = [
				$key + 1,
				$value->id,
				$CreateDate,
				$value->tujuan,
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
			return redirect()->to('mftujuankirim');
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
			return redirect()->to('mftujuankirim');
		}

		$data = $this->request->getPost();
		//$data['id'] = $this->model->getMaxId() + 1;
		$data['added_by'] = current_user()->UserID;

		//return $this->response->setJSON($data);

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
			return redirect()->to('mftujuankirim');
		}

		$data = $this->request->getPost();

		$data['updated_by'] = current_user()->UserID;
		$id=$data["id"];
		unset($data["id"]);

		//return $this->response->setJSON($data);

		if ($this->model->updateById($id, $data)) {
			$msg = 'Data berhasil diupdate';
			session()->setFlashData('success', $msg);
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
}
