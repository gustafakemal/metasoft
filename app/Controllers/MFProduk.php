<?php

namespace App\Controllers;

use App\Models\MFProdukModel;
use CodeIgniter\I18n\Time;

class MFProduk extends BaseController
{
	private $model;
	private $errors = [];

	public function __construct()
	{
		$this->model = new MFProdukModel();
	}

	public function index()
	{
		$this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Input Produk MF', '/mfproduk');

		return view('MFProduk/input', [
			'page_title' => 'Data Produk MF',
			'breadcrumbs' => $this->breadcrumbs->render(),
		]);
	}

    public function edit($id)
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Data Produk MF', '/mfproduk');

        dd($this->model->joinTest($id));

        $data = $this->model->getById($id);

        return view('MFProduk/edit', [
            'page_title' => 'Edit Produk MF',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'data' => $data->getFirstRow(),
            'segments' => (new \App\Models\SegmenModel())->getAll(),
            'sales' => (new \App\Models\SalesModel())->asObject()->findAll(),
            'customer' => (new \App\Models\CustomerModel())->asObject()->findAll(),
            'tujuan_kirim' => (new \App\Models\MFTujuanKirimModel())->asObject()->findAll()
        ]);
    }

	public function productSearch()
	{
		$keyword = $this->request->getPost('keyword');
		$query = $this->model->getByFgdNama("$keyword");

		$data = [];
		foreach($query as $key => $val) {
			$edit_btn = '<a data-toggle="tooltip" data-placement="left" title="Edit" href="'. site_url('MFProduk/edit/' . $val->id) .'" class="btn btn-sm btn-success mr-2"><i class="far fa-edit"></i></a>';
			$del_btn = '<a data-toggle="tooltip" data-placement="left" title="Hapus" href="#" class="btn btn-sm btn-danger del-item-product" data-keyword="'. $keyword .'" data-id="'. $val->id .'"><i class="far fa-trash-alt"></i></a>';
			$data[] = [
				$key + 1,
                $edit_btn . $del_btn,
				$val->nama_produk,
                (new \App\Models\SegmenModel())->getName($val->segmen),
                (new \App\Models\CustomerModel())->getName($val->customer),
                (new \App\Models\SalesModel())->getName($val->sales),
                $this->common->dateFormat($val->added),
				$val->added_by,
                $this->common->dateFormat($val->updated),
				$val->updated_by,
			];
		}

		$response = [
			'success' => (count($data) > 0) ? true : false,
			'data' => $data
		];

		return $this->response->setJSON($response);
	}

    public function delItemProduct()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('mfproduk');
        }

        $id = $this->request->getPost('id');

        $query = $this->model->where('id', $id)
                            ->set(['aktif' => 'T'])
                            ->update();

        if($query) {
            $response = [
                'success' => true,
                'msg' => 'Data produk berhasil dihapus.'
            ];
        } else {
            $response = [
                'success' => false,
                'msg' => 'Data produk gagal dihapus.'
            ];
        }

        return $this->response->setJSON($response);
    }

	public function apiGetAll()
	{
        $query = $this->model->getMFProduk();
        
        $data = [];
        foreach ($query->getResult() as $key => $item) {
            $confirm = "'Yakin menghapus?'";
            $edit = '<a href="#" class="edit-produk" data-id="' . $item->id . '"><i class=" far fa-edit"></i></a>';
            $del = ' <a href="' . site_url('mfproduk/delete/' . $item->id) . '" onclick="return confirm(' . $confirm . ')"><i class=" far fa-trash-alt"></i></a>';
            $data[] = [
                $key + 1,
                $item->nama_produk,
                $item->OpsiTeks,
                $item->NamaPemesan,
                $item->SalesName,
                $this->common->dateFormat($item->added),
                $item->added_by,
                $this->common->dateFormat($item->updated),
                $item->updated_by,
                $edit . $del
            ];
        }

        $response = [
            'success' => true,
            'data' => $data
        ];

        return $this->response->setJSON($response);

	}

    public function delItemKelProduk($id_produk, $id_part)
    {
        $query = (new \App\Models\MFKelompokProdukModel())->where('id_produk', $id_produk)
                                                        ->where('id_part', $id_part)
                                                        ->delete();

        if($query) {
            return redirect()->back()
                ->with('success', 'Item berhasil dihapus.');
        } else {
            return redirect()->back()
                ->with('error', 'Item gagal dihapus.');
        }
    }

	public function apiGetById()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$id = $this->request->getPost('id');
		$data = $this->model->getById($id)->getFirstRow();

//		$warna_model = new \App\Models\MFProdukWarnaModel();
//		$data->backside_colors = $warna_model->getByProdID($id, 'B');
//		$data->frontside_colors = $warna_model->getByProdID($id, 'F');
//
//		$data->finishing = (new \App\Models\MFProdukFinishingModel())->getByProdID($id);
//		$data->khusus = (new \App\Models\MFProdukKhususModel())->getByProdID($id);
//		$data->manual = (new \App\Models\MFProdukManualModel())->getByProdID($id);
		
		$response = [
			'success' => (null !== $this->model->getById($id)) ? true : false,
			'data' => $data
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
        $data['nama_produk'] = strtoupper($data['nama_produk']);

		if($this->model->insert($data, false)) {
            session()->setFlashdata('success', 'Data berhasil ditambahkan.');
            $response = [
                'success' => true,
                'msg' => 'Data berhasil ditambahkan.',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
                'data' => null
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

		if(array_key_exists('frontside_colors', $data) || array_key_exists('backside_colors', $data)) {
			$data_colors = [];
			if(array_key_exists('frontside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['frontside_colors'], $data['id'], 'F'));
			}
			if(array_key_exists('backside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['backside_colors'], $data['id'], 'B'));
			}
			if(count($data_colors) > 0) {
				$color_model = new \App\Models\MFProdukWarnaModel();
				$update_colors = $color_model->reInsert($data_colors);
			}
		}

		if(array_key_exists('finishing', $data)) {
			$data_finishing = $this->productProcess($data['finishing'], $data['id']);
			if(count($data_finishing) > 0) {
				$finishing_model = new \App\Models\MFProdukFinishingModel();
				$update_finishing = $finishing_model->reInsert($data_finishing);
			}
		}

		if(array_key_exists('manual', $data)) {
			$data_manual = $this->productProcess($data['manual'], $data['id']);
			if(count($data_manual) > 0) {
				$manual_model = new \App\Models\MFProdukManualModel();
				$update_manual = $manual_model->reInsert($data_manual);
			}
		}

		if(array_key_exists('khusus', $data)) {
			$data_khusus = $this->productProcess($data['khusus'], $data['id']);
			if(count($data_khusus) > 0) {
				$khusus_model = new \App\Models\MFProdukKhususModel();
				$update_khusus = $khusus_model->reInsert($data_khusus);
			}
		}

		// return $this->response->setJSON(['data' => $data]);

		$main_data = $this->model->save($data);

		if(isset($update_colors) && !$update_colors) {
			array_push($this->errors, 'Data warna gagal diupdate.');
		}
		if(isset($update_finishing) && !$update_finishing) {
			array_push($this->errors, 'Data finishing gagal diupdate.');
		}
		if(isset($update_manual) && !$update_manual) {
			array_push($this->errors, 'Data manual gagal diupdate.');
		}
		if(isset($update_khusus) && !$update_khusus) {
			array_push($this->errors, 'Data khusus gagal diupdate.');
		}
		if(!$main_data) {
			$this->errors = array_merge($this->errors, $this->model->errors());
		}

    	if( count($this->errors) > 0 ) {
    		return $this->response->setJSON([
    			'success' => false,
    			'msg' => '<p>' . implode('</p><p>', $this->errors) . '</p>',
    			'data' => null,
    		]);
    	}

    	return $this->response->setJSON([
    		'success' => true,
    		'msg' => 'Data revisi berhasil diupdate',
    		'data' => [
    			'id' => $data['id'],
    		],
    	]);
	}

	public function apiAddRevision() {

		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$data = $this->request->getPost();
		$id = $this->model->idGenerator();
		$data['id'] = $id;
		// $data['fgd'] = $this->model->fgdGenerator();
		$data['revisi'] = 1 + $this->model->getLastRev('220600000007')->revisi;
		$data['added_by'] = current_user()->UserID;

		return $this->response->setJSON(['data' => $data]);

		if(array_key_exists('frontside_colors', $data) || array_key_exists('backside_colors', $data)) {
			$data_colors = [];
			if(array_key_exists('frontside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['frontside_colors'], $id, 'F'));
			}
			if(array_key_exists('backside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['backside_colors'], $id, 'B'));
			}
			if(count($data_colors) > 0) {
				$color_model = new \App\Models\MFProdukWarnaModel();
				$insert_colors = $color_model->insertBatch($data_colors);
			}
		}

		if(array_key_exists('finishing', $data)) {
			$data_finishing = $this->productProcess($data['finishing'], $id);
			if(count($data_finishing) > 0) {
				$finishing_model = new \App\Models\MFProdukFinishingModel();
				$insert_finishing = $finishing_model->insertBatch($data_finishing);
			}
		}

		if(array_key_exists('manual', $data)) {
			$data_manual = $this->productProcess($data['manual'], $id);
			if(count($data_manual) > 0) {
				$manual_model = new \App\Models\MFProdukManualModel();
				$insert_manual = $manual_model->insertBatch($data_manual);
			}
		}

		if(array_key_exists('khusus', $data)) {
			$data_khusus = $this->productProcess($data['khusus'], $id);
			if(count($data_khusus) > 0) {
				$khusus_model = new \App\Models\MFProdukKhususModel();
				$insert_khusus = $khusus_model->insertBatch($data_khusus);
			}
		}

		$main_data = $this->model->insert($data);

		if(isset($insert_colors) && !$insert_colors) {
			array_push($this->errors, 'Data warna gagal diinsert.');
		}
		if(isset($insert_finishing) && !$insert_finishing) {
			array_push($this->errors, 'Data finishing gagal diinsert.');
		}
		if(isset($insert_manual) && !$insert_manual) {
			array_push($this->errors, 'Data manual gagal diinsert.');
		}
		if(isset($insert_khusus) && !$insert_khusus) {
			array_push($this->errors, 'Data khusus gagal diinsert.');
		}
		if(!$main_data) {
			$this->errors = array_merge($this->errors, $this->model->errors());
		}

    	if( count($this->errors) > 0 ) {
    		if(isset($insert_colors) && $insert_colors) {
    			$color_model->deleteByProdID($id);
    		}
    		if(isset($insert_finishing) && $insert_finishing) {
    			$finishing_model->deleteByProdID($id);
    		}
    		if(isset($insert_manual) && $insert_manual) {
    			$manual_model->deleteByProdID($id);
    		}
    		if(isset($insert_khusus) && $insert_khusus) {
    			$khusus_model->deleteByProdID($id);
    		}
    		return $this->response->setJSON([
    			'success' => false,
    			'msg' => '<p>' . implode('</p><p>', $this->errors) . '</p>',
    			'data' => null,
    		]);
    	}

    	return $this->response->setJSON([
    				'success' => true,
    				'msg' => 'Revisi baru berhasil ditambahkan.',
    				'data' => [
    					'id' => $data['id'],
    				],
    			]);
	}

	public function apiEditProcess()
	{
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('mfproduk');
        }

        $data = $this->request->getPost();
        $data['updated_by'] = current_user()->UserID;
        $data['nama_produk'] = strtoupper($data['nama_produk']);

        if($this->model->save($data, false)) {
            session()->setFlashdata('success', 'Data berhasil diupdate.');
            $response = [
                'success' => true,
                'msg' => 'Data berhasil diupdate.',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
                'data' => null
            ];
        }

        return $this->response->setJSON($response);
	}

	public function delete($id)
	{
        if($this->model->delete($id)) {
            return redirect()->back()
                ->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()
                ->with('error', 'Data gagal dihapus');
        }
	}

	private function productColors($colors, $prod_id, $initial_position)
	{
		if(!is_array($colors) || count($colors) == 0) {
			return [];
		}

		return array_map(function($item) use($prod_id, $initial_position) {
			return [
				'id_produk' => $prod_id,
				'posisi' => $initial_position,
				'tinta' => $item
			];
		}, $colors);
	}

	private function productProcess($process, $prod_id)
	{
		if(!is_array($process) || count($process) == 0) {
			return [];
		}

		return array_map(function($item) use($prod_id) {
			return [
				'id_produk' => $prod_id,
				'proses' => $item
			];
		}, $process);
	}
}
