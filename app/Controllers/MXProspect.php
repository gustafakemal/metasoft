<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class MXProspect extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\MXProspectModel();
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        return view('MXProspect/MXProspect_List', [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
        ]);
    }

    /**
     * Endpoint ini digunakan untuk menampilkan Form / inputan
     *
     * @return string
     */
    public function add(): string
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        $views = [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'alternatif' => $this->model->getAlternatif(),
        ];

        $views = array_merge($views, $this->requiredFields());

        return view('MXProspect/MXProspect', $views);
    }

    /**
     * Endpoint ini digunakan untuk memproses inputan
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function addProcess(): RedirectResponse
    {
        $data = $this->request->getPost();

        $data_request = $this->transformDataRequest($data);

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

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function apiSearch(): ResponseInterface
    {
        $keyword = $this->request->getPost('keyword');

        $query = $this->model->getByKeyword($keyword);

        $results = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $key => $row) {

                $alt_confirm = "return confirm('Menambahkan alternatif')";

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-success edit-rev-item mr-2" href="'. site_url('listprospek/edit/' . $row->NoProspek) .'" title="Edit"><i class="far fa-edit"></i></a> ';
                $alt = '<a title="Tambah Alt" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-info alt-item" href="#" data-no-prospect="'. $row->NoProspek .'" onclick="' . $alt_confirm . '" title="Alt"><i class="far fa-clone"></i></a> ';
                $hapus = '<a title="Hapus" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-danger del-prospek" data-no-prospek="' . $row->NoProspek . '" data-alt="' . $row->Alt . '" href="#"><i class="far fa-trash-alt"></i></a>';

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

    /**
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function createAlt(): ResponseInterface
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

    /**
     * @param $NoProspek
     * @return string
     */
    public function edit($NoProspek): string
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('MXProspect', '/');

        $query = $this->model->getByNoProspect($NoProspek);
        $qq = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($NoProspek, $query->getResult()[0]->Alt);

        $views = [
            'page_title' => 'MX Prospect',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'alternatif' => $this->model->getAlternatif(),
            'data' => $query->getResult()[0],
            'prospek_aksesori' => $qq->getResult()
        ];

        $views = array_merge($views, $this->requiredFields());

        return view('MXProspect/MXProspect_edit', $views);
    }

    /**
     * @return RedirectResponse
     * @throws \ReflectionException
     */
    public function editProcess(): RedirectResponse
    {
        $data = $this->request->getPost();

        $data_request = $this->transformDataRequest($data, true);

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

    /**
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        $NoProspek = $this->request->getPost('NoProspek');
        $Alt = $this->request->getPost('Alt');

        if( $this->model->deleteProspek($NoProspek, $Alt) ) {
            return $this->response->setJSON([
                'success' => true,
                'msg' => 'Data berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Data gagal dihapus'
            ]);
        }
    }

    /**
     * @param array $data_request
     * @param $updated
     * @return array
     * @throws \Exception
     */
    private function transformDataRequest(array $data_request, $updated = false): array
    {
        $newarr = [];
        foreach ($data_request as $key => $row) {
            switch($key) {
                case 'Tebal':
                case 'Panjang':
                case 'Lebar':
                case 'Pitch':
                case 'TebalMat1':
                case 'TebalMat2':
                case 'TebalMat3':
                case 'TebalMat4':
                case 'Toleransi':
                case 'Kapasitas':
                    $newarr[$key] = floatval(str_replace(',', '', trim($row)));
                    break;
                case 'NamaProduk':
                    $newarr[$key] = strtoupper($row);
                    break;
                default:
                    $newarr[$key] = $row;
                    break;
            }
        }

        if( $updated ) {
            $newarr['Updated'] = Time::now()->toDateTimeString();
            $newarr['UpdatedBy'] = session()->get('UserID');
        } else {
            $newarr['Tanggal'] = Time::now()->toDateTimeString();
            $newarr['CreatedBy'] = session()->get('UserID');
            $newarr['NoProspek'] = $this->model->noProspek();
            $newarr['Alt'] = 1;
        }

        return $newarr;
    }

    /**
     * @return array
     */
    private function requiredFields(): array
    {
        return [
            'customers' => (new \App\Models\CustomerModel())->getCustomers(),
            'jenisproduk' => (new \App\Models\MXJenisProdukModel())->asObject()->findAll(),
            'segmen' => (new \App\Models\MXSegmenModel())->asObject()->findAll(),
            'konten' => (new \App\Models\MXKontenModel())->asObject()->findAll(),
            'material' => (new \App\Models\MXMaterialModel())->asObject()->findAll(),
            'bagmaking' => (new \App\Models\MXBagMakingModel())->asObject()->findAll(),
            'bottom' => (new \App\Models\MXBottomModel())->asObject()->findAll(),
            'aksesori' => (new \App\Models\MXAksesoriModel())->asObject()->findAll(),
            'areakirim' => (new \App\Models\MXAreaKirimModel())->asObject()->findAll(),
        ];
    }
}