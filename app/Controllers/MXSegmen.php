<?php
//getUpdate($id,$set) getAll() getList()
namespace App\Controllers;

use App\Models\MXSegmenModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class MXSegmen extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new MXSegmenModel();
	}

    public function index()
	{
		$this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Segmen Metaflex', '/mxsegmen');
		$data = $this->model->getAll();
		//dd ($data);
		return view('MXSegmen/main', [
			'page_title' => 'Segmen Metaflex',
			'breadcrumbs' => $this->breadcrumbs->render(),
			'main_menu' => (new \App\Libraries\Menu())->render(),
			'record' => $data
		]);
	}

	public function add()
    {
        $request = $this->request->getVar();
		//dd($request);
        if (! $this->validate([
			'segmen'=> [
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => 'Silakan Isi Kolom Segmen',
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/mxsegmen/')->withInput()->with('success', $validation->listErrors() );
        }
           
        $data =[
            'Nama' => $request['segmen'],
            'Aktif' => $request['aktif'],
        ];

        //dd($data);
        $this->model->save($data);
        session()->setFlashdata('success','Penambahan Segmen Berhasil');
        return redirect()->to('/mxsegmen/');
    }


	public function update() 
	{
		$request = $this->request->getVar();
		$data = $this->model->getUpdate($request['id'],$request['set']);
		
		session()->setFlashdata('pesan','Update Segmen Berhasil');
        return redirect()->to('MXSegmen/main');
	}
	
}
