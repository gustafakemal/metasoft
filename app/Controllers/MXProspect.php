<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

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
    public function add()
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
            'alternatif' => $this->db->getAlternatif(),
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

        $data_request['NoProspek'] = $this->db->noProspek();
        $data_request['Alt'] = 1;

        $data_request['NamaProduk'] = strtoupper($data_request['NamaProduk']);
        $data_request['Tanggal'] = Time::now()->toDateTimeString();
        $data_request['CreatedBy'] = session()->get('UserID');
        $data_request['Tebal'] = floatval(str_replace(',', '', trim($data_request['Tebal'])));
        $data_request['Panjang'] = floatval(str_replace(',', '', trim($data_request['Panjang'])));
        $data_request['Lebar'] = floatval(str_replace(',', '', trim($data_request['Lebar'])));
        $data_request['Pitch'] = floatval(str_replace(',', '', trim($data_request['Pitch'])));
        $data_request['TebalMat1'] = floatval(str_replace(',', '', trim($data_request['TebalMat1'])));
        $data_request['TebalMat2'] = floatval(str_replace(',', '', trim($data_request['TebalMat2'])));
        $data_request['TebalMat3'] = floatval(str_replace(',', '', trim($data_request['TebalMat3'])));
        $data_request['TebalMat4'] = floatval(str_replace(',', '', trim($data_request['TebalMat4'])));
        $data_request['Toleransi'] = floatval(str_replace(',', '', trim($data_request['Toleransi'])));
        $data_request['Kapasitas'] = floatval(str_replace(',', '', trim($data_request['Kapasitas'])));

        /** Insert form isian ke DB */
        $insert_data = $this->db->insert($data_request, false);

        if ( $insert_data ) {
            if( array_key_exists('aksesori', $data_request) && count($data_request['aksesori']) > 0) {
                $noprospek = $data_request['NoProspek'];
                $data_aksesori = array_map(function ($item) use ($noprospek, $data_request) {
                    return [
                        'NoProspek' => $noprospek,
                        'Alt' => $data_request['Alt'],
                        'Aksesori' => $item
                    ];
                }, $data_request['aksesori']);
                $pa_model = new \App\Models\MXProspekAksesoriModel();
                $pa_model->insertBatch($data_aksesori);
            }

            return redirect()->back()
                            ->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()
                ->with('error', '<p>' . implode('</p><p>', $this->db->errors()) . '</p>');
        }

    }

    public function index()
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        return view('Forms/MXProspect', [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
        ]);
    }
}