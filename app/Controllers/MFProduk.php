<?php

namespace App\Controllers;

use App\Models\MFProdukModel;
use CodeIgniter\I18n\Time;

class MFProduk extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new MFProdukModel();
	}

	// public function index2() {
	// 	dd($this->model->getByFgdNama2('c'));
	// }

	public function index()
	{
		$segmen_model = new \App\Models\SegmenModel();
		$customer_model = new \App\Models\CustomerModel();
		$sales_model = new \App\Models\SalesModel();
		$tujuankirim_model = new \App\Models\MFTujuanKirimModel();
		$jeniskertas_model = new \App\Models\MFJenisKertasModel();
		$jenistinta_model = new \App\Models\MFJenisTintaModel();
		$jenisflute_model = new \App\Models\MFJenisFluteModel();
		$packing_model = new \App\Models\MFPackingModel();
		$finishing_model = new \App\Models\MFProsesFinishingModel();
		$manual_model = new \App\Models\MFProsesManualModel();
		$khusus_model = new \App\Models\MFProsesKhususModel();
		return view('MFProduk/input', [
			'page_title' => 'Input Produk MF',
			'opsi_segmen' => $segmen_model->getAll(),
			'opsi_customer' => $customer_model->getOpsi(),
			'opsi_sales' => $sales_model->getOpsi(),
			'opsi_tujuankirim' => $tujuankirim_model->getOpsi(),
			'opsi_kertas' => $tujuankirim_model->getOpsi(),
			'opsi_jeniskertas' => $jeniskertas_model->getOpsi(),
			'opsi_jenistinta' => $jenistinta_model->getOpsi(),
			'opsi_jenisflute' => $jenisflute_model->getOpsi(),
			'opsi_innerpack' => $packing_model->getOpsi('Inner'),
			'opsi_outerpack' => $packing_model->getOpsi('Outer'),
			'opsi_deliverypack' => $packing_model->getOpsi('Delivery'),
			'opsi_finishing' => $finishing_model->getOpsi(),
			'opsi_manual' => $manual_model->getOpsi(),
			'opsi_khusus' => $khusus_model->getOpsi(),
		]);
	}

	public function productSearch()
	{
		$keyword = $this->request->getPost('keyword');
		$query = $this->model->getByFgdNama('C');
		//dd($query);
		//exit;


		$data = [];
		foreach($query as $key => $val) {
			$edit_btn = '<button type="button" class="btn btn-sm btn-success edit-rev-item mr-2" data-id="'.$val->id.'">Edit</button>';
			$revisi_btn = '<button type="button" class="btn btn-sm btn-danger rev-item" data-id="'.$val->id.'">Revisi</button>';
			$data[] = [
				$key + 1,
				$val->fgd,
				$val->revisi,
				$val->nama_produk,
				$val->segmen,
				$val->pemesan,
				$val->sales,
				$val->added,
				$val->added_by,
				$val->updated,
				$val->updated_by,
				$edit_btn . $revisi_btn
			];
		}

		$response = [
			'success' => true,
			'data' => $data
		];

		return $this->response->setJSON($response);
	}

	public function apiGetAll()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

	}

	public function apiGetById()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$id = $this->request->getPost('id');
		
		$response = [
			'success' => (null !== $this->model->getById($id)) ? true : false,
			'data' => $this->model->getById($id)
		];

		return $this->response->setJSON($response);
	}

	public function apiAddProcess()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$data = $this->request->getPost();
		$id = $this->model->idGenerator();
		$data['id'] = $id;
		$data['added_by'] = current_user()->UserID;
		// return $this->response->setJSON(['data' => $data]);

    	if( $this->model->insert($data) ) {
    		$msg = 'Data berhasil ditambahkan.';
    		session()->setFlashData('success', $msg);
    		$response = [
    			'success' => true,
    			'msg' => $msg,
    			'data' => [
    				'id' => $data['id'],
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

	public function apiEditRevision()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$data = $this->request->getPost();
		$data['updated_by'] = current_user()->UserID;
		unset($data['fgd']);
		// return $this->response->setJSON(['data' => $data]);

    	if( $this->model->save($data) ) {
    		$msg = 'Data revisi berhasil ditambahkan';
    		session()->setFlashData('success', $msg);
    		$response = [
    			'success' => true,
    			'msg' => $msg,
    			'data' => [
    				'id' => $data['id'],
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

	public function apiAddRevision() {
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$data = $this->request->getPost();
		$data['added_by'] = current_user()->UserID;

		$id = $this->model->idGenerator();
		$data['id'] = $id;
		// return $this->response->setJSON(['data' => $data]);

    	if( $this->model->insert($data) ) {
    		$msg = 'Data berhasil ditambahkan';
    		session()->setFlashData('success', $msg);
    		$response = [
    			'success' => true,
    			'msg' => $msg,
    			'data' => [
    				'id' => $data['id'],
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
		
	}

	public function delete($id)
	{
	
		return redirect()->back()
			->with('error', 'Data gagal dihapus');
	}
}
