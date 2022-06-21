<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\I18n\Time;

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
        if($this->request->getMethod() !== 'post') {
            return redirect()->to('customer');
        }

    	$query = $this->model->getCustomers();

    	$data = [];
    	foreach ($query as $key => $value) {
    		// $detail = '<a href="#" data-id="'.$value->NoPemesan.'" class="item-detail" title="Detail"><i class="far fa-file-alt"></i></a> ';
    		// $edit = '<a href="#" data-id="'.$value->NoPemesan.'" class="item-edit" title="Edit"><i class="far fa-edit"></i></a> ';
            // $hapus = '<a href="'.site_url('customer/delete/'.$value->NoPemesan).'" onclick="return confirm(\'Apa Anda yakin menghapus user ini?\')" title="Delete"><i class="fas fa-trash-alt"></i></a>';
             
			$detail = '<a class="btn btn-primary btn-sm item-detail mr-1" href="#" data-id="' . $value->NoPemesan . '" title="Detail"><i class="far fa-file-alt"></i></a>';
			$edit = '<a class="btn btn-success btn-sm item-edit mr-1" href="#" data-id="' . $value->NoPemesan . '" title="Edit"><i class="far fa-edit"></i></a>';
			$hapus = '<a class="btn btn-danger btn-sm" href="' . site_url('customer/delete/'.$value->NoPemesan) . '" data-id="' . $value->NoPemesan . '" onclick="return confirm(\'Apa Anda yakin menghapus user ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
	
		
			
			
			
			$CreateDate = (Time::parse($value->CreateDate))->toDateTimeString();
    		$data[] = [
    			$key + 1,
                $value->NoPemesan,
    			$CreateDate,
    			$value->NamaPemesan,
                $value->Alamat,
                $value->NoFax,
                $value->NoTelp,
    			$value->ContactPerson1,
                $value->ContactPerson2,
    			$value->WajibPajak,
                $value->NPWP,
                $value->AlamatPengiriman1,
                $value->AlamatPengiriman2,
                $value->AlamatPenagihan,
                $value->FlagAktif,
                $value->CreateBy,
                $value->UpdateBy,
                $value->LastUpdate,
    			$detail . $edit . $hapus
    		];
    	}

    	return $this->response->setJSON($data);
    }

    public function apiGetById()
    {
        if($this->request->getMethod() !== 'post') {
            return redirect()->to('customer');
        }

    	$no_pemesan = $this->request->getPost('noPemesan');
        $modified = $this->request->getPost('modified') ?? false;

    	$query = $this->model->getById($no_pemesan);

    	if(count($query) == 1) {
            $data = $query[0];
            
            if($modified) {
                $data = [];
                foreach ($query[0] as $key => $value) {
                    if($key == 'InternEkstern') {
                        $data[$key] = ($value == 'I') ? 'Internal' : 'Eksternal';
                    } elseif($key == 'FlagAktif') {
                        $data[$key] = ($value == 'A') ? 'Aktif' : 'Nonaktif';
                    } elseif($key == 'WajibPajak') {
                        $data[$key] = ($value == 'Y') ? 'Ya' : 'Tidak';
                    } elseif($key == 'CreateDate' || $key == 'LastUpdate') {
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
        if($this->request->getMethod() !== 'post') {
            return redirect()->to('customer');
        }

    	$data = $this->request->getPost();
    	$data['NoPemesan'] = $this->model->getMaxNoPemesan() + 1;
        $data['CreateBy'] = current_user()->UserID;

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
        if($this->request->getMethod() !== 'post') {
            return redirect()->to('customer');
        }
        
    	$data = $this->request->getPost();
        $data['UpdateBy'] = current_user()->UserID;

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