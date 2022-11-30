<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class MXProspect extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\MXProspectModel();
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
            'alternatif' => $this->model->getAlternatif(),
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

        $data_request['NoProspek'] = $this->model->noProspek();
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
        $insert_data = $this->model->insert($data_request, false);

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
                ->with('error', '<p>' . implode('</p><p>', $this->model->errors()) . '</p>');
        }

    }

    public function index()
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        return view('Forms/MXProspect_List', [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
        ]);
    }

    public function apiSearch()
    {
        $keyword = $this->request->getPost('keyword');

        $query = $this->model->getByKeyword($keyword);

        $results = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $key => $row) {

                $alt_confirm = "return confirm('Menambahkan alternatif')";

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-success edit-rev-item mr-2" href="'. site_url('listprospek/edit/' . $row->NoProspek) .'" title="Edit"><i class="far fa-edit"></i></a> ';
                $alt = '<a title="Tambah Alt" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-info alt-item" href="#" data-no-prospect="'. $row->NoProspek .'" onclick="' . $alt_confirm . '" title="Alt"><i class="far fa-clone"></i></a> ';
                $hapus = '<a title="Hapus" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-danger" href="#" onclick=""><i class="far fa-trash-alt"></i></a>';

                $results[] = [
                    $key + 1,
                    $row->NoProspek,
                    $row->Alt,
                    $row->NamaProduk,
                    $row->NamaPemesan,
                    $row->Jumlah,
                    $row->Area,
                    $row->CreatedBy,
                    $row->Catatan,
                    '',
                    $edit . $alt . $hapus
                ];
            }
        }

        return $this->response->setJSON($results);
    }

    public function createAlt()
    {
        $NoProspek = $this->request->getPost('NoProspek');

        $query = $this->model->getByNoProspect($NoProspek);
        $max_alt = $this->model->getMaxAlt($NoProspek)->getResult();

        $results = $query->getResultArray()[0];
        $results['Alt'] = $max_alt[0]->Alt + 1;
        $results['Tanggal'] = Time::now()->toDateTimeString();
        $results['Created'] = Time::now()->toDateTimeString();
        $results['CreatedBy'] = session()->get('UserID');

        if( $this->model->insert($results, false) ) {
            return $this->response->setJSON([
                'success' => true,
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
            ]);
        }
    }

    private function apiResponse($query)
    {
        $results = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $key => $row) {

                $alt_confirm = "return confirm('Menambahkan alternatif')";

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-success edit-rev-item mr-2" href="#" title="Edit"><i class="far fa-edit"></i></a> ';
                $alt = '<a title="Tambah Alt" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-info alt-item" href="#" data-no-prospect="'. $row->NoProspect .'" onclick="' . $alt_confirm . '" title="Alt"><i class="far fa-clone"></i></a> ';
                $hapus = '<a title="Hapus" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-danger" href="#" onclick=""><i class="far fa-trash-alt"></i></a>';

                $results[] = [
                    $key + 1,
                    $row->NoProspek,
                    $row->Alt,
                    $row->NamaProduk,
                    $row->Pemesan,
                    $row->Jumlah,
                    $row->Area,
                    $row->CreatedBy,
                    $row->Catatan,
                    '',
                    $edit . $alt . $hapus
                ];
            }
        }

        return $results;
    }

    public function edit($NoProspek)
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        $query = $this->model->getByNoProspect($NoProspek);
        $qq = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($NoProspek, $query->getResult()[0]->Alt);

        $customers = (new \App\Models\CustomerModel())->getCustomers();
        $jenisproduk = (new \App\Models\MXJenisProdukModel())->asObject()->findAll();
        $segmen = (new \App\Models\MXSegmenModel())->asObject()->findAll();
        $konten = (new \App\Models\MXKontenModel())->asObject()->findAll();
        $material = (new \App\Models\MXMaterialModel())->asObject()->findAll();
        $bagmaking = (new \App\Models\MXBagMakingModel())->asObject()->findAll();
        $bottom = (new \App\Models\MXBottomModel())->asObject()->findAll();
        $aksesori = (new \App\Models\MXAksesoriModel())->asObject()->findAll();
        $areakirim = (new \App\Models\MXAreaKirimModel())->asObject()->findAll();

        return view('Forms/MXProspect_edit', [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'alternatif' => $this->model->getAlternatif(),
            'customers' => $customers,
            'jenisproduk' => $jenisproduk,
            'segmen' => $segmen,
            'konten' => $konten,
            'material' => $material,
            'bagmaking' => $bagmaking,
            'bottom' => $bottom,
            'aksesori' => $aksesori,
            'areakirim' => $areakirim,
            'data' => $query->getResult()[0],
            'prospek_aksesori' => $qq->getResult()
        ]);
    }

    public function editProcess()
    {
        $data_request = $this->request->getPost();

        $data_request['NamaProduk'] = strtoupper($data_request['NamaProduk']);
        $data_request['Updated'] = Time::now()->toDateTimeString();
        $data_request['UpdatedBy'] = session()->get('UserID');
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

        if ( $this->model->updateData($data_request, $data_request['NoProspek'], $data_request['Alt']) ) {
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
                $pa_model->delByProspek($noprospek, $data_request['Alt']);
                $pa_model->insertBatch($data_aksesori);
            }

            return redirect()->back()
                ->with('success', 'Data berhasil diupdate.');
        } else {
            return redirect()->back()
                ->with('error', '<p>' . implode('</p><p>', $this->model->errors()) . '</p>');
        }
    }
}