<?php

namespace App\Controllers;

class MXProspect extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = new \App\Models\MXProspectModel();
    }
    /**
     * Endpoint ini digunakan untuk menampilkan Form / inputan
     *
     * @return string
     */
    public function index()
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        $customers = (new \App\Models\CustomerModel())->getCustomers();
        $jenisproduk = (new \App\Models\MXJenisProdukModel())->asObject()->findAll();
        $segmen = (new \App\Models\MXSegmenModel())->asObject()->findAll();
        $konten = (new \App\Models\MXKontenModel())->asObject()->findAll();
        $material = (new \App\Models\MXMaterialModel())->asObject()->findAll();
        $bagmaking = (new \App\Models\MXBagMakingModel())->asObject()->findAll();
        $bottom = (new \App\Models\MXBottomModel())->asObject()->findAll();
        $aksesori = (new \App\Models\MXAksesoriModel())->asObject()->findAll();
        $areakirim = (new \App\Models\MXAreaKirimModel())->asObject()->findAll();

        return view('Forms/MXProspect', [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'customers' => $customers,
            'jenisproduk' => $jenisproduk,
            'segmen' => $segmen,
            'konten' => $konten,
            'material' => $material,
            'bagmaking' => $bagmaking,
            'bottom' => $bottom,
            'aksesori' => $aksesori,
            'areakirim' => $areakirim,
        ]);
    }

    /**
     * Endpoint ini digunakan untuk memproses inputan
     *
     * @return void
     */
    public function addProcess()
    {
        $data_request = $this->request->getPost();

        dd($data_request);

        $data_request['NoProspek'] = 1234;

        /** Insert form isian ke DB */
        $insert_data = $this->db->insert($data_request);

        if ( $insert_data ) {
            return redirect()->back()
                            ->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()
                ->with('error', '<p>' . implode('</p><p>', $this->db->errors()) . '</p>');
        }

    }
}