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

		
	}

	public function apiAddProcess()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}
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
