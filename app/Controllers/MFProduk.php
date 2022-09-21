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

        if($this->request->getGet('keyword') !== null) {
            $query_string = [
                'query' => true,
                'keyword' => $this->request->getGet('keyword')
            ];
        } else {
            $query_string = [
                'query' => false,
                'keyword' => null
            ];
        }

		return view('MFProduk/input', [
			'page_title' => 'Data Produk MF',
			'breadcrumbs' => $this->breadcrumbs->render(),
            'query_string' => $query_string
		]);
	}

    public function edit($id)
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Data Produk MF', '/mfproduk');

        $data = $this->model->getEditingData($id);

        return view('MFProduk/edit', [
            'page_title' => 'Edit Produk MF',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'data' => $data[0],
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
                'redirect_url' => site_url('MFProduk/edit/' . $id),
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
}
