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
        	'page_title' => 'Customer',
        ]);
    }

    public function apiGetAll()
    {
    	$query = $this->model->getCustomers();

    	$data = [];
    	foreach ($query as $key => $value) {
    		$detail = '<a href="#" data-id="'.$value->NoPemesan.'" class="customer-detail" title="Detail"><i class="far fa-file-alt"></i></a> ';
    		$edit = '<a href="#" title="Edit"><i class="far fa-edit"></i></a> ';
            $hapus = '<a href="#" onclick="return confirm(\'Apa Anda yakin menghapus user ini?\')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
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
    	sleep(10);
    	// $data = $this->request->getPost();
    	// $data['NoPemesan'] = $this->model->getMaxNoPemesan() + 1;

    	// if( $this->model->insert($data, false) ) {
    	if( true ) {
    		$response = [
    			'success' => true,
    			'data' => [
    				// 'NoPemesan' => $data['NoPemesan'],
    			],
    		];
    	} else {
    		$response = [
    			'success' => false,
    			'data' => null,
    		];
    	}

    	return $this->response->setJSON($response);
    }
}