<?php

namespace App\Controllers;

use App\Models\SalesModel;
use CodeIgniter\I18n\Time;

class Sales extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new SalesModel();
	}

	public function index()
	{
		
		return view('Sales/main', [
			'page_title' => 'Data Sales',
		]);
	}

	public function apiGetAll()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('sales');
		}

		$query = $this->model->getSales();

		$data = [];
		foreach ($query as $key => $value) {
			//$detail = '<a href="#" data-id="' . $value->id . '" class=" btn item-detail" title="Detail"><i class="far fa-file-alt"></i></a> ';
			//$edit = '<a href="#" data-id="' . $value->id . '" class="item-edit" title="Edit"><i class="far fa-edit"></i></a> ';
			//$hapus = '<a href="' . site_url('sales/delete/' . $value->id) . '" onclick="return confirm(\'Apa Anda yakin menghapus user ini?\')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
			 
			$detail = '<a class="btn btn-primary btn-sm item-detail mr-1" href="#" data-id="' . $value->SalesID . '" title="Detail"><i class="far fa-file-alt"></i></a>';
			$edit = '<a class="btn btn-success btn-sm item-edit mr-1" href="#" data-id="' . $value->SalesID . '" title="Edit"><i class="far fa-edit"></i></a>';
			$hapus = '<a class="btn btn-danger btn-sm" href="' . site_url('sales/delete/' . $value->SalesID) . '" data-id="' . $value->SalesID . '" onclick="return confirm(\'Apa Anda yakin menghapus data ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
	
		
			$data[] = [
				$key + 1,
				$value->SalesID,
				$value->SalesName,
				$value->NIK,
				$value->FlagAktif,
				$detail . $edit . $hapus
			];
		}

		return $this->response->setJSON($data);
	}

	public function apiGetById()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('sales');
		}

		$id = $this->request->getPost('id');
		$modified = $this->request->getPost('modified') ?? false;

		$query = $this->model->getById($id);

		if (count($query) == 1) {
			$data = $query[0];

			if ($modified) {
				$data = [];
				foreach ($query[0] as $key => $value) {
					if ($key == 'FlagAktif') {
						$data[$key] = ($value == 'A') ? 'Ya' : 'Tidak';
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
			return redirect()->to('sales');
		}

		$data = $this->request->getPost();
		$data['SalesID'] = $this->model->getMaxId() + 1;
		
		//return $this->response->setJSON($data);

		if ($this->model->insert($data, false)) {
			$msg = 'Data berhasil ditambahkan';
			session()->setFlashData('success', $msg);
			$response = [
				'success' => true,
				'msg' => $msg,
				'data' => [
					'SalesID' => $data['SalesID'],
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
			return redirect()->to('sales');
		}

		$data = $this->request->getPost();

		$id = $this->request->getPost('SalesID');

    	$query = $this->model->getById($id);
		

		//return $this->response->setJSON($data);

		if ($this->model->updateById($id, $data)) {
			$msg = 'Data berhasil diupdate';
			session()->setFlashData('success', $msg);
			$response = [
				'success' => true,
				'msg' => $msg,
				'data' => [
					'SalesID' => $id,
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
