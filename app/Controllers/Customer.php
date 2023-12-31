<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Customer extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new CustomerModel();
	}

    /**
     * @return string
     */
    public function index(): string
    {
        return view('Customer/main', [
        	'page_title' => 'Data Pelanggan',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render()
        ]);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint GET /api/master/customer
     */
    public function apiGetAll(): ResponseInterface
    {
        $access = $this->common->getAccess(uri_string(true));
        $navigation = new \App\Libraries\Navigation();
        $navigation->setAccess($access);

    	$query = $this->model->getCustomers();

    	$data = [];
    	foreach ($query as $key => $value) {

            $detail = $navigation->button('detail', [
                'data-id' => $value->NoPemesan,
            ]);
            $edit = $navigation->button('edit', [
                'data-id' => $value->NoPemesan,
            ]);
            $hapus = $navigation->button('delete', [
                'href' => site_url('pelanggan/delete/' . $value->NoPemesan),
            ]);
			
			$CreateDate = (Time::parse($value->CreateDate))->toDateTimeString();
    		$data[] = [
    			$key + 1,
                $value->NoPemesan,
                $this->common->dateFormat($CreateDate),
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
                $this->common->dateFormat($value->LastUpdate),
    			$detail . $edit . $hapus
    		];
    	}

    	return $this->response->setJSON($data);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint GET /api/master/customer/$1
     */
    public function apiGetById($no_pemesan): ResponseInterface
    {
        $modified = $this->request->getGet('modified') == 'yes';

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

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint POST /api/master/customer
     */
    public function apiAddProcess(): ResponseInterface
    {
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

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint PUT /api/master/customer
     */
    public function apiEditProcess(): ResponseInterface
    {
        $data = $this->request->getPost();
        $data['UpdateBy'] = current_user()->UserID;
        unset($data['_method']);

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

    /**
     * @param $NoPemesan
     * @return RedirectResponse
     */
    public function delete($NoPemesan): RedirectResponse
    {
    	if($this->model->deleteById($NoPemesan)) {
    		return redirect()->back()
    						->with('success', 'Data berhasil dihapus');
    	}

    	return redirect()->back()
    					->with('error', 'Data gagal dihapus');
    }

    /**
     * @return ResponseInterface
     */
    public function getSelectOptions(): ResponseInterface
    {
        $query = $this->model->getCustomers();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => $row->NoPemesan,
                'name' => $row->NamaPemesan
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}