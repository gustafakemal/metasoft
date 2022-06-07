<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customer extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new CustomerModel();
	}

    public function index()
    {
        return view('Customer/main', [
        	'page_title' => 'Data Pelanggan',
        ]);
    }

    public function apiGetAll()
    {
    	$query = $this->model->getCustomers();

    	$data = [];
    	foreach ($query as $key => $value) {
    		$detail = '<a href="#" data-id="'.$value->NoPemesan.'" class="item-detail" title="Detail"><i class="far fa-file-alt"></i></a> ';
    		$edit = '<a href="#" data-id="'.$value->NoPemesan.'" class="item-edit" title="Edit"><i class="far fa-edit"></i></a> ';
            $hapus = '<a href="'.site_url('customer/delete/'.$value->NoPemesan).'" onclick="return confirm(\'Apa Anda yakin menghapus user ini?\')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
    		$data[] = [
    			$key + 1,
    			$value->CreateDate,
    			$value->NamaPemesan,
    			$value->ContactPerson1,
    			$value->WajibPajak,
    			$detail . $edit . $hapus
    		];
    	}

    	return $this->response->setJSON($data);
    }

    public function apiGetById()
    {
    	$no_pemesan = $this->request->getPost('noPemesan');

    	$query = $this->model->getById($no_pemesan);

    	if(count($query) == 1) {
    		$response = [
    			'success' => true,
    			'data' => $query[0]
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
    	$data = $this->request->getPost();
    	$data['NoPemesan'] = $this->model->getMaxNoPemesan() + 1;

    	if( $this->model->insert($data, false) ) {
    		$msg = 'Data berhasil ditambahkan';
    		session()->setFlashData('success', $msg);
    		$response = [
    			'success' => true,
    			'msg' => $msg,
    			'data' => [
    				'NoPemesan' => $data['NoPemesan'],
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
    	$data = $this->request->getPost();

    	if( $this->model->updateById($data['NoPemesan'], $data) ) {
    		$msg = 'Data berhasil diupdate';
    		session()->setFlashData('success', $msg);
    		$response = [
    			'success' => true,
    			'msg' => $msg,
    			'data' => [
    				'NoPemesan' => $data['NoPemesan'],
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

    public function delete($NoPemesan)
    {
    	if($this->model->deleteById($NoPemesan)) {
    		return redirect()->back()
    						->with('success', 'Data berhasil dihapus');
    	}

    	return redirect()->back()
    					->with('error', 'Data gagal dihapus');
    }
}