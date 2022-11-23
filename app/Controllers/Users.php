<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\I18n\Time;

class Users extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new UsersModel();
	}

    public function index()
    {
        
		$test = $this->model->getByUserID('005236');
		if($test->getNumRows()>0)
			return $test->getResult()[0]->Nama;
		else {
            return "test";
		}

    }

    public function apiGetNamaById()
    {
		$id = $this->request->getPost('nik');
		$query = $this->model->getNamaById($id);
    	
		if(count($query) == 1) {
            $data = $query[0];
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

		return $this->response->setJSON($data);
    }
}