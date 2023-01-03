<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class MXProspect extends BaseController
{
    private $model;
    private $status = [
        0 => 'BATAL',
        10 => 'INPUT',
        20 => 'ESTIMASI',
        30 => 'ORDER'
    ];

    public function __construct()
    {
        $this->model = new \App\Models\MXProspectModel();
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return view('MXProspect/MXProspect_List', [
            'page_title' => 'List Prospek',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
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
        $views = [
            'page_title' => 'Input Prospek',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'alternatif' => $this->model->getAlternatif(),
        ];

        $views = array_merge($views, $this->requiredFields());

        return view('MXProspect/MXProspect', $views);
    }

    /**
     * Endpoint ini digunakan untuk memproses inputan
     *
     * @return RedirectResponse
     * @throws \ReflectionException
     */
    public function addProcess(): RedirectResponse
    {
        $data = $this->request->getPost();
        $alt_get = $this->request->getGet('alt');
        $copyprospek_get = $this->request->getGet('copyprospek');

        $type = 'add';
        if( $alt_get !== null && $copyprospek_get !== null) {
            if($alt_get == '1' && $copyprospek_get == '1') {
                $type = 'copyprospek';
            } else {
                $type = 'alt';
            }
        } elseif( $alt_get !== null && $copyprospek_get == null ) {
            if($alt_get == '1') {
                $type = 'alt';
            }
        } else {
            $type = 'add';
        }

//        $type = ( $this->request->getGet('alt') !== null && $this->request->getGet('alt') == '1' ) ? 'alt' : 'add';

        $data_request = $this->transformDataRequest($data, $type);
        $data_request['Status'] = 10;

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

                $data_jumlah = array_map(function ($item) use ($noprospek, $data_request) {
                    return [
                        'NoProspek' => $noprospek,
                        'Alt' => $data_request['Alt'],
                        'Jumlah' => $item
                    ];
                }, $data_request['jml']);
                $pj_model = new \App\Models\MXProspekJumlahModel();
                $pj_model->insertBatch($data_jumlah);
            }

            if($type == 'alt' || $type == 'copyprospek') {
                return redirect()->to('listprospek/edit/' . $data_request['NoProspek'] . '/' . $data_request['Alt'])
                    ->with('success', 'Alternatif berhasil ditambahkan');
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
    public function apiGetAll(): ResponseInterface
    {
        $query = $this->model->getAll();

        $sess_access = array_values( array_filter(session()->get('priv'), function ($item) {
            return $item->modul_id == 21;
        }) );

        $results = [];
        if($query->getNumRows() > 0) {
            foreach ($query->getResult() as $key => $row) {

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success edit-rev-item" href="'. site_url('listprospek/edit/' . $row->NoProspek . '/' . $row->Alt) .'" title="Edit"><i class="far fa-edit"></i></a>';
//                $alt = '<a title="Tambah Alt" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-info alt-item" href="'. site_url('listprospek/add/' . $row->NoProspek . '/' . $row->Alt) .'" title="Alt"><i class="far fa-clone"></i></a>';
                $alt = '<a title="Tambah Alt" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-info alt-item" data-no-prospek="' . $row->NoProspek . '" data-alt="' . $row->Alt . '" href="#" title="Alt"><i class="far fa-clone"></i></a>';
                $hapus = '<a title="Hapus" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-danger del-prospek" data-no-prospek="' . $row->NoProspek . '" data-alt="' . $row->Alt . '" data-status="' . $row->Status . '" href="#"><i class="far fa-trash-alt"></i></a>';

                $minta = '<div class="switch-nav dropdown">
                            <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                                <div class="fungsi">
                                    ---
                                </div>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item">Estimasi</a>
                                    <a href="#" class="dropdown-item">Sample</a>
                                    <a href="#" class="dropdown-item">Batal</a>
                                </div>
                            </button>
                        </div>';

                if($sess_access[0]->access == 3) {
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">' . $edit . $alt . $hapus . '</div>';
                } else {
                    $action = '<a title="Detail" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success" href="'. site_url('listprospek/detail/' . $row->NoProspek . '/' . $row->Alt) .'"><i class="far fa-file-alt"></i></a>';
                }

                $is_checked = ($row->Prioritas) ? ' checked' : '';

                $results[] = [
                    $key + 1,
                    $row->NoProspek,
                    $row->Alt,
                    $row->NamaProduk,
                    $row->NamaPemesan,
                    $row->Jumlah,
                    $row->Nama,
                    $this->common->dateFormat($row->Created),
                    $row->Catatan,
                    $this->status[$row->Status],
                    $minta,
                    '<input' . $is_checked . ' type="checkbox" data-size="xs" class="chbx" data-no-prospek="' . $row->NoProspek . '" data-no-prospek="' . $row->Alt . '">',
                    $action,
                    $row->Prioritas
                ];
            }
        }

        return $this->response->setJSON($results);
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

                $edit = '<a title="Edit" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success edit-rev-item" href="'. site_url('listprospek/edit/' . $row->NoProspek . '/' . $row->Alt) .'" title="Edit"><i class="far fa-edit"></i></a>';
                $alt = '<a title="Tambah Alt" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-info alt-item" href="'. site_url('listprospek/add/' . $row->NoProspek . '/' . $row->Alt) .'" title="Alt"><i class="far fa-clone"></i></a>';
                $hapus = '<a title="Hapus" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-danger del-prospek" data-no-prospek="' . $row->NoProspek . '" data-alt="' . $row->Alt . '" data-status="' . $row->Status . '" href="#"><i class="far fa-trash-alt"></i></a>';

                $minta = '<div class="switch-nav dropdown">
                            <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                                <div class="fungsi">
                                    ---
                                </div>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item">Estimasi</a>
                                    <a href="#" class="dropdown-item">Sample</a>
                                    <a href="#" class="dropdown-item">Batal</a>
                                </div>
                            </button>
                        </div>';

                $results[] = [
                    $key + 1,
                    $row->NoProspek,
                    $row->Alt,
                    $row->NamaProduk,
                    $row->NamaPemesan,
                    $row->Jumlah,
                    $row->Nama,
                    $this->common->dateFormat($row->Created),
                    $row->Catatan,
                    $this->status[$row->Status],
                    $minta,
                    '<div class="btn-group" role="group" aria-label="Basic example">' . $edit . $alt . $hapus . '</div>'
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

    public function alt($NoProspek, $Alt)
    {
        $query = $this->model->getByNoProspectAndAlt($NoProspek, $Alt);
        $qq = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($NoProspek, $query->getResult()[0]->Alt);

        $copyprospek = ($this->request->getGet('copyprospek') != null && $this->request->getGet('copyprospek') == '1') ? 1 : 0;

        $views = [
            'page_title' => 'Copy Prospek',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'alternatif' => $this->model->getAlternatif(),
            'copyprospek' => $copyprospek,
            'data' => $query->getResult()[0],
            'prospek_aksesori' => $qq->getResult()
        ];

        $views = array_merge($views, $this->requiredFields());

        return view('MXProspect/MXProspect_alt', $views);
    }

    public function altProcess()
    {
        $request = $this->request->getPost();
        dd($request);
    }

    /**
     * @param $NoProspek
     * @return string
     */
    public function edit($NoProspek, $Alt): string
    {
        $query = $this->model->getByNoProspectAndAlt($NoProspek, $Alt);
        $qq = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($NoProspek, $query->getResult()[0]->Alt);
        $jml = (new \App\Models\MXProspekJumlahModel())->getByProspekAlt($NoProspek, $query->getResult()[0]->Alt);

        $views = [
            'page_title' => 'Edit Prospek',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'alternatif' => $this->model->getAlternatif(),
            'data' => $query->getResult()[0],
            'prospek_aksesori' => $qq->getResult(),
            'jumlah' => ($jml->getNumRows() > 0) ? $jml->getResult() : []
        ];

        $views = array_merge($views, $this->requiredFields());

        return view('MXProspect/MXProspect_edit', $views);
    }

    /**
     * @param $NoProspek
     * @return string
     */
    public function detail($NoProspek, $Alt): string
    {
        $query = $this->model->getDetailByNoProspectAndAlt($NoProspek, $Alt);
        $qq = (new \App\Models\MXProspekAksesoriModel())->getByProspekAlt($NoProspek, $query->getResult()[0]->Alt);

        $id_materials = [$query->getResult()[0]->Material1, $query->getResult()[0]->Material2, $query->getResult()[0]->Material3, $query->getResult()[0]->Material4];
        $materials = (new \App\Models\MXMaterialModel())->asObject()->find($id_materials);

        $views = [
            'page_title' => 'Prospek',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render(),
            'alternatif' => $this->model->getAlternatif(),
            'data' => $query->getResult()[0],
            'materials' => $materials,
            'prospek_aksesori' => $qq->getResult()
        ];

        $views = array_merge($views, []);

        return view('MXProspect/MXProspect_view', $views);
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

            if( array_key_exists('jml', $data_request) && count($data_request['jml']) > 0) {
                $noprospek = $data_request['NoProspek'];
                $data_jumlah = array_map(function ($item) use ($noprospek, $data_request) {
                    return [
                        'NoProspek' => $noprospek,
                        'Alt' => $data_request['Alt'],
                        'Jumlah' => $item
                    ];
                }, $data_request['jml']);
                $pj_model = new \App\Models\MXProspekJumlahModel();
                $pj_model->delByProspek($noprospek, $data_request['Alt']);
                $pj_model->insertBatch($data_jumlah);
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
        $Status = (int)$this->request->getPost('Status');

//        return $this->response->setJSON(['noprospek' => $NoProspek, 'alt' => $Alt, 'status' => $Status]);

        if($Status >= 20) {
            $newdata = ['Status' => 0];
            if($this->model->updateData($newdata, $NoProspek, $Alt)) {
                $response = ['success' => true, 'msg' => 'Data berhasil diupdate'];
            } else {
                $response = ['success' => false, 'msg' => 'Data gagal diupdate'];
            }
        } else {
            if( $this->model->deleteProspek($NoProspek, $Alt) ) {
                $response = ['success' => true, 'msg' => 'Data berhasil dihapus'];
            } else {
                $response = ['success' => false, 'msg' => 'Data gagal dihapus'];
            }
        }

        return $this->response->setJSON($response);
    }

    public function setPriority()
    {
        $NoProspek = $this->request->getPost('NoProspek');
//        $Alt = $this->request->getPost('Alt');
        $priority = (int)$this->request->getPost('priority');

        if( $this->model->setPriority($NoProspek, $priority) ) {
            $response = [
                'success' => true
            ];
            if($priority) {
                $this->setRestUnpriority($NoProspek);
            }
        } else {
            $response = [
                'success' => false
            ];
        }

        return $this->response->setJSON($response);
    }

    private function setRestUnpriority($NoProspek)
    {
        return $this->model->setRestUnpriority($NoProspek);
    }

    /**
     * @param array $data_request
     * @param string $type
     * @return array
     * @throws \Exception
     */
    private function transformDataRequest(array $data_request, string $type = 'add'): array
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

        if( $type == 'update' ) {
            $newarr['Updated'] = Time::now()->toDateTimeString();
            $newarr['UpdatedBy'] = session()->get('UserID');
        }

        if($type == 'add') {
            $newarr['Tanggal'] = Time::now()->toDateTimeString();
            $newarr['CreatedBy'] = session()->get('UserID');
            $newarr['NoProspek'] = $this->model->noProspek();
            $newarr['Alt'] = 1;
        }

        if( $type == 'alt' ) {
            $max_alt = $this->model->getMaxAlt($newarr['NoProspek'])->getResult();
            $newarr['Alt'] = $max_alt[0]->Alt + 1;
            $newarr['Tanggal'] = Time::now()->toDateTimeString();
            $newarr['Created'] = Time::now()->toDateTimeString();
            $newarr['CreatedBy'] = session()->get('UserID');
        }

        if( $type == 'copyprospek' ) {
            $newarr['NoProspek'] = $this->model->noProspek();
            $newarr['Alt'] = 1;
            $newarr['Tanggal'] = Time::now()->toDateTimeString();
            $newarr['Created'] = Time::now()->toDateTimeString();
            $newarr['CreatedBy'] = session()->get('UserID');
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
            'konten' => (new \App\Models\MXJenisKontenModel())->asObject()->findAll(),
            'material' => (new \App\Models\MXMaterialModel())->asObject()->findAll(),
            'bagmaking' => (new \App\Models\MXBagMakingModel())->asObject()->findAll(),
            'bottom' => (new \App\Models\MXBottomModel())->asObject()->findAll(),
            'aksesori' => (new \App\Models\MXAksesoriModel())->asObject()->findAll(),
            'areakirim' => (new \App\Models\MXAreaKirimModel())->asObject()->findAll(),
        ];
    }
}