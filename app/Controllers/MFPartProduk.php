<?php

namespace App\Controllers;

use App\Models\MFPartProdukModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Files\File;

class MFPartProduk extends BaseController
{
	private $model;
	private $errors = [];

    private $filedokcr_max_size = 512000;
    private $filedokcr_extension = ['jpg', 'jpeg', 'pdf'];
    private $filedokcr_mime_type = ['image/jpg', 'image/jpeg', 'application/pdf'];

	public function __construct()
	{
		$this->model = new MFPartProdukModel();
	}

	public function index()
	{
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Data Part Produk MF', '/mfproduk');

		return view('MFPartProduk/cari', [
			'page_title' => 'Data Part Produk MF',
            'breadcrumbs' => $this->breadcrumbs->render(),
		]);
	}

	public function addPartProduct()
	{
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Part Produk', '/mfpartproduk');
        $this->breadcrumbs->add('Input Part Produk MF', '/mfproduk');

		return view('MFPartProduk/input', [
			'page_title' => 'Input Part Produk MF',
            'ref' => $this->request->getGet('ref'),
            'id_produk' => $this->request->getGet('id_produk'),
            'breadcrumbs' => $this->breadcrumbs->render(),
		]);
	}

    public function editPartProduct($id, $is_revision = 0)
    {
        $this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Part Produk', '/mfpartproduk');
        $this->breadcrumbs->add(($is_revision == 0) ? 'Edit Part Produk MF' : 'Revisi Part Produk MF', '/mfproduk');

        $data = $this->model->getEditingData($id)[0];

        return view('MFPartProduk/edit', [
            'page_title' => ($is_revision == 0) ? 'Edit Part Produk MF' : 'Revisi Part Produk MF',
            'breadcrumbs' => $this->breadcrumbs->render(),
            'data' => $data,
            'id_produk' => $this->request->getGet('id_produk'),
            'is_revision' => $is_revision,
            'rev_no' => ($is_revision == 1) ? $this->model->revGenerator($data->fgd) : $data->revisi,
        ]);
    }

    public function detailPartProduct($id)
    {
        $data = $this->model->getById($id);

        $tujuankirim_model = new \App\Models\MFTujuanKirimModel();
        $jeniskertas_model = new \App\Models\MFJenisKertasModel();
        $jenistinta_model = new \App\Models\MFJenisTintaModel();
        $jenisflute_model = new \App\Models\MFJenisFluteModel();
        $packing_model = new \App\Models\MFPackingModel();
        return view('MFPartProduk/detail', [
            'page_title' => 'Input Part Produk MF',
            'data' => $data,
            'id' => $id,
            'opsi_tujuankirim' => $tujuankirim_model->getOpsi(),
            'opsi_kertas' => $tujuankirim_model->getOpsi(),
            'jeniskertas' => $jeniskertas_model->getNama($data->kertas),
            'opsi_jenistinta' => $jenistinta_model->getOpsi(),
            'jenisflute' => $jenisflute_model->getNama($data->flute),
            'innerpack' => $packing_model->getNama($data->inner_pack, 'Inner'),
            'outerpack' => $packing_model->getNama($data->outer_pack, 'Outer'),
            'deliverypack' => $packing_model->getNama($data->deliver_pack, 'Delivery'),
        ]);
    }

    public function dokcr($id)
    {
        $data = $this->model->getById($id);

        if (file_exists(WRITEPATH . 'uploads/file_dokcr/' . $data->file_dokcr)) {
            $path = WRITEPATH . 'uploads/file_dokcr/' . $data->file_dokcr;
            $finfo = new \finfo(FILEINFO_MIME);
            $type = $finfo->file($path);

            header("Content-Type: " . $type);
            header("Content-Length: " . filesize($path));

            readfile($path);
            exit;
        } else {
            return service('response')->setStatusCode(404)->setBody('404 File tidak ditemukan');
        }
    }

    public function apiAddSisi($id_part = 0)
    {
        $model = new \App\Models\MFSisiProdukModel();
        $model_warna = new \App\Models\MFProdukWarnaModel();
        $model_manual = new \App\Models\MFProdukManualModel();
        $model_finishing = new \App\Models\MFProdukFinishingModel();
        $model_khusus = new \App\Models\MFProdukKhususModel();

        $data = $this->request->getPost();
        unset($data['fscolors']);
        unset($data['bscolors']);
        unset($data['manualcolors']);
        unset($data['finishingcolors']);
        unset($data['khususcolors']);

        $data['added_by'] = session()->get('UserID');

        if($id_part == 1) {
            $no_fgd = $data['no_fgd'];
            $revisi = $data['revisi'];
            $id_part = $this->model->getIDByFgdAndRevisi($no_fgd, $revisi);
            $data['id_part'] = $id_part['id'];
            unset($data['no_fgd']);
            unset($data['revisi']);
        }

        if($model->insert($data)) {

            $id_sisi = $model->insertID();

            $data_fs = [];
            $data_bs = [];
            if(array_key_exists('fscolor', $data)) {
                for($i = 0;$i < count($data['fscolor']);$i++) {
                    $data_fs[] = [
                        'id_sisi' => $id_sisi,
                        'posisi' => 'F',
                        'tinta' => $data['fscolor'][$i],
                        'added_by' => session()->get('UserID')
                    ];
                }
            }

            if(array_key_exists('bscolor', $data)) {
                for($i = 0;$i < count($data['bscolor']);$i++) {
                    $data_bs[] = [
                        'id_sisi' => $id_sisi,
                        'posisi' => 'B',
                        'tinta' => $data['bscolor'][$i],
                        'added_by' => session()->get('UserID')
                    ];
                }
            }

            if(array_key_exists('bscolor', $data) || array_key_exists('fscolor', $data)) {
                if (count($data_fs) > 0 && count($data_bs) > 0) {
                    $data_colors = array_merge($data_fs, $data_bs);
                } elseif (count($data_fs) > 0 && count($data_bs) == 0) {
                    $data_colors = $data_fs;
                } elseif (count($data_fs) == 0 && count($data_bs) > 0) {
                    $data_colors = $data_bs;
                } else {
                    $data_colors = [];
                }

                $model_warna->insertBatch($data_colors);
            }

            if(array_key_exists('manualcolor', $data)) {
                $data_manual = [];
                for($i = 0;$i < count($data['manualcolor']);$i++) {
                    $data_manual[] = [
                        'id_sisi' => $id_sisi,
                        'proses' => $data['manualcolor'][$i]
                    ];
                }
                $model_manual->insertBatch($data_manual);
            }

            if(array_key_exists('finishingcolor', $data)) {
                $data_finishing = [];
                for($i = 0;$i < count($data['finishingcolor']);$i++) {
                    $data_finishing[] = [
                        'id_sisi' => $id_sisi,
                        'proses' => $data['finishingcolor'][$i]
                    ];
                }
                $model_finishing->insertBatch($data_finishing);
            }

            if(array_key_exists('khususcolor', $data)) {
                $data_khusus = [];
                for($i = 0;$i < count($data['khususcolor']);$i++) {
                    $data_khusus[] = [
                        'id_sisi' => $id_sisi,
                        'proses' => $data['khususcolor'][$i]
                    ];
                }
                $model_khusus->insertBatch($data_khusus);
            }

            $response = [
                'success' => true,
                'data' => $data,
                'msg' => 'Data sisi berhasil ditambahkan.'
            ];
        } else {
            $response = [
                'success' => false,
                'data' => $data,
                'msg' => '<p>' . implode('</p><p>', $model->errors()) . '</p>'
            ];
        }

        return $this->response->setJSON($response);
    }

    public function apiEditSisi()
    {
        $model = new \App\Models\MFSisiProdukModel();
        $model_warna = new \App\Models\MFProdukWarnaModel();
        $model_manual = new \App\Models\MFProdukManualModel();
        $model_finishing = new \App\Models\MFProdukFinishingModel();
        $model_khusus = new \App\Models\MFProdukKhususModel();

        $data = $this->request->getPost();
        unset($data['fscolors']);
        unset($data['bscolors']);
        unset($data['manualcolors']);
        unset($data['finishingcolors']);
        unset($data['khususcolors']);
        unset($data['trevisi']);

        $data['updated_by'] = current_user()->UserID;

        if($model->save($data)) {
            $data_fs = [];
            $data_bs = [];
            if(array_key_exists('fscolor', $data)) {
                for($i = 0;$i < count($data['fscolor']);$i++) {
                    $data_fs[] = [
                        'id_sisi' => $data['id'],
                        'posisi' => 'F',
                        'tinta' => $data['fscolor'][$i],
                        'added_by' => session()->get('UserID')
                    ];
                }
            }

            if(array_key_exists('bscolor', $data)) {
                for($i = 0;$i < count($data['bscolor']);$i++) {
                    $data_bs[] = [
                        'id_sisi' => $data['id'],
                        'posisi' => 'B',
                        'tinta' => $data['bscolor'][$i],
                        'added_by' => session()->get('UserID')
                    ];
                }
            }

            if(count($data_fs) > 0 && count($data_bs) > 0) {
                $data_colors = array_merge($data_fs, $data_bs);
            } elseif (count($data_fs) > 0 && count($data_bs) == 0) {
                $data_colors = $data_fs;
            } elseif (count($data_fs) == 0 && count($data_bs) > 0) {
                $data_colors = $data_bs;
            } else {
                $data_colors = [];
            }

            $model_warna->deleteAllSisi($data['id']);
            $model_warna->insertBatch($data_colors);

            if(array_key_exists('manualcolor', $data)) {
                $data_manual = [];
                for($i = 0;$i < count($data['manualcolor']);$i++) {
                    $data_manual[] = [
                        'id_sisi' => $data['id'],
                        'proses' => $data['manualcolor'][$i]
                    ];
                }
                $model_manual->deleteAllSisi($data['id']);
                $model_manual->insertBatch($data_manual);
            }

            if(array_key_exists('finishingcolor', $data)) {
                $data_finishing = [];
                for($i = 0;$i < count($data['finishingcolor']);$i++) {
                    $data_finishing[] = [
                        'id_sisi' => $data['id'],
                        'proses' => $data['finishingcolor'][$i]
                    ];
                }
                $model_finishing->deleteAllSisi($data['id']);
                $model_finishing->insertBatch($data_finishing);
            }

            if(array_key_exists('khususcolor', $data)) {
                $data_khusus = [];
                for($i = 0;$i < count($data['khususcolor']);$i++) {
                    $data_khusus[] = [
                        'id_sisi' => $data['id'],
                        'proses' => $data['khususcolor'][$i]
                    ];
                }
                $model_khusus->deleteAllSisi($data['id']);
                $model_khusus->insertBatch($data_khusus);
            }

            $response = [
                'success' => true,
                'data' => $data,
                'msg' => 'Data sisi berhasil diupdate.'
            ];
        } else {
            $response = [
                'success' => false,
                'data' => $data,
                'msg' => '<p>' . implode('</p><p>', $model->errors()) . '</p>'
            ];
        }

        return $this->response->setJSON($response);
    }

    public function actualNomorSisi($id_part)
    {
        $no = (new \App\Models\MFSisiProdukModel())->lastNomorSisi($id_part) + 1;

        return $this->response->setJSON(['success' => true, 'no_sisi' => $no]);
    }

    public function apiAllSisi()
    {
        $query = (new \App\Models\MFSisiProdukModel())->getAllSisi();

        $data = [];
        foreach ($query->getResult() as $key => $item) {

            $del_confirm = "'Hapus item ini?'";
            $view = '<a href="#" title="View" class="view-sisi" data-id="' . $item->id . '"><i class="far fa-file-alt"></i></a>';
            $edit = ' <a href="#" title="Edit" class="edit-sisi" data-revisi="' . $item->revisi . '" data-fgd="' . $item->fgd . '" data-id="' . $item->id . '"><i class="far fa-edit"></i></a>';
            $del = ' <a href="' . site_url('mfpartproduk/delSisi/' . $item->id) . '" title="Hapus" onclick="return confirm('.$del_confirm.')"><i class="far fa-trash-alt"></i></a>';

            $added = Time::parse($item->added);
            $updated = Time::parse($item->updated);

            $data[] = [
                $item->sisi,
                $item->frontside,
                $item->backside,
                $item->special_req,
                $this->common->dateFormat($item->added),
                $item->added_by,
                ($added->equals($updated)) ? '' : $this->common->dateFormat($item->updated),
                $item->updated_by,
                $view . $edit . $del
            ];
        }

        $response = [
            'success' => true,
            'data' => $data
        ];

        return $this->response->setJSON($response);
    }

    public function apiAllSisiByPart()
    {
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfpartproduk');
		}

        $id = $this->request->getPost('id');
        $is_revision = $this->request->getPost('is_revision');

        $query = (new \App\Models\MFSisiProdukModel())->getAllSisiByPart($id);

        if($query->getNumRows() > 0) {
            $data = [];
            foreach ($query->getResult() as $key => $row) {
                $del_confirm = "'Hapus item ini?'";
                $view = '<a href="#" title="View" class="view-sisi" data-id="' . $row->id . '"><i class="far fa-file-alt"></i></a>';
                $edit = ' <a href="#" title="Edit" class="edit-sisi" data-id="' . $row->id . '"><i class="far fa-edit"></i></a>';
                $del = ' <a href="' . site_url('mfpartproduk/delSisi/' . $row->id) . '" title="Hapus" onclick="return confirm('.$del_confirm.')"><i class="far fa-trash-alt"></i></a>';

                $added = Time::parse($row->added);
                $updated = Time::parse($row->updated);

                $data[] = [
                    $row->sisi,
                    $row->frontside,
                    $row->backside,
                    $row->special_req,
                    $this->common->dateFormat($row->added),
                    $row->added_by,
                    ($added->equals($updated)) ? '' : $this->common->dateFormat($row->updated),
                    $row->updated_by,
                ];
                if($is_revision === null) {
                    array_push($data[$key], $view . $edit . $del);
                }
            }

            $response = [
                'success' => true,
                'data' => $data
            ];
        } else {
            $response = [
                'success' => false,
                'data' => []
            ];
        }

        return $this->response->setJSON($response);
    }

    public function delSisi($id)
    {
        $model = new \App\Models\MFSisiProdukModel();

        if($model->where('id', $id)->set(['aktif' => 'T'])->update()) {
            return redirect()->back()
                            ->with('success', 'Item sisi berhasil dihapus');
        } else {
            return redirect()->back()
                ->with('error', 'Item sisi gagal dihapus');
        }
    }

    public function getSisiById($id)
    {
        $query = (new \App\Models\MFSisiProdukModel())->getSisiById($id);
        $query_fsbs = (new \App\Models\MFProdukWarnaModel())->getTintaBySisi($id);
        $query_manual = (new \App\Models\MFProdukManualModel())->getTintaBySisi($id);
        $query_finishing = (new \App\Models\MFProdukFinishingModel())->getTintaBySisi($id);
        $query_khusus = (new \App\Models\MFProdukKhususModel())->getTintaBySisi($id);

        if($query->getNumRows() > 0) {
            $data = $query->getFirstRow();
            $data->fs_colors = array_values(array_filter($query_fsbs->getResult(), function ($item) {
                return $item->posisi == 'F';
            })); // array_values digunakan untuk me-reset keys
            $data->bs_colors = array_values(array_filter($query_fsbs->getResult(), function ($item) {
                return $item->posisi == 'B';
            }));
            $data->manual_colors = $query_manual->getResult();
            $data->finishing_colors = $query_finishing->getResult();
            $data->khusus_colors = $query_khusus->getResult();
            $data->added = $this->common->dateFormat($data->added);
            $data->updated = $this->common->dateFormat($data->updated);
            $response = [
                'success' => true,
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => true,
                'data' => null
            ];
        }

        return $this->response->setJSON($response);
    }

	public function partProductSearch()
	{
		$keyword = $this->request->getPost('keyword');
        $full = (! $this->request->getPost('full') );
        $id_produk = $this->request->getPost('id_produk');

        if($keyword == '') {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Silahkan isikan form cari',
                'data' => []
            ]);
        }

		$query = $this->model->getByFgdNama("$keyword");

        if(count($query) == 0) {
            return $this->response->setJSON([
                'success' => false,
                'msg' => 'Data tidak ditemukan.',
                'data' => []
            ]);
        }

		$data = [];
		foreach($query as $key => $val) {
            $confirm = "'Hapus part produk?'";
			$edit_btn = '<a title="Edit" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-success edit-rev-item mr-2" href="' . site_url('partproduk/edit/' . $val->id) . '"><i class="far fa-edit"></i></a>';
			$revisi_btn = '<a title="Revisi" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-info rev-item" href="' . site_url('partproduk/rev/' . $val->id . '/1').'"><i class="far fa-clone"></i></a>';
            $del_btn = '<a title="Hapus" data-toggle="tooltip" data-placement="left" class="btn btn-sm btn-danger" href="' . site_url('partproduk/del/' . $val->id).'" onclick="return confirm('.$confirm.')"><i class="far fa-trash-alt"></i></a>';

            $added = Time::parse($val->added);
            $updated = Time::parse($val->updated);

            if($full) {
                $data[] = [
                    $key + 1,
                    $edit_btn . $revisi_btn . $del_btn,
                    $val->fgd,
                    $val->revisi,
                    $val->nama,
                    (new \App\Models\MFJenisKertasModel())->getNama($val->kertas),
                    (new \App\Models\MFJenisFluteModel())->getNama($val->flute),
                    $val->metalize,
                    (int)$val->panjang . 'x' . (int)$val->lebar . 'x' . (int)$val->tinggi,
                    $this->common->dateFormat($val->added),
                    $val->added_by,
                    ($added->equals($updated)) ? '' : $this->common->dateFormat($val->updated),
                    $val->updated_by
                ];
            } else {
                $add_btn = ((new \App\Models\MFKelompokProdukModel())->checkLinkedProduct($val->id, $id_produk)) ? '<button type="button" class="btn btn-danger del-from-product" data-idpart="'.$val->id.'" data-idproduk="'.$id_produk.'">Batalkan</button>' : '<button type="button" class="btn btn-primary add-to-product" data-idpart="'.$val->id.'" data-idproduk="'.$id_produk.'">Tambahkan</button>';

                $data[] = [
                    $key + 1,
                    $val->fgd,
                    $val->revisi,
                    $val->nama,
                    (new \App\Models\MFJenisKertasModel())->getNama($val->kertas),
                    (new \App\Models\MFJenisFluteModel())->getNama($val->flute),
                    (int)$val->panjang . 'x' . (int)$val->lebar . 'x' . (int)$val->tinggi,
                    $add_btn
                ];
            }
		}

		$response = [
			'success' => true,
			'data' => $data
		];

		return $this->response->setJSON($response);
	}

    public function delPartProduk($id)
    {
        $query = (new \App\Models\MFPartProdukModel())->where('id', $id)
                                                    ->set(['aktif' => 'T'])
                                                    ->update();
        return redirect()->back()
                        ->with('success', 'Part produk berhasil dihapus');
    }

    public function getDistinctiveFGD()
    {
        $query = $this->model->getDistinctiveFGD();

        if($query->getNumRows() > 0) {
            $data = [];
            foreach ($query->getResult() as $row) {
                $data[] = $row->fgd;
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

    public function getRevisiByFGD($fgd)
    {
        $query = $this->model->getRevisiByFGD($fgd);

        if($query->getNumRows() > 0) {
            $data = [];
            foreach ($query->getResult() as $row) {
                $data[] = $row->revisi;
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

	public function apiGetAll()
	{
        $query = $this->model->getAll();

        $data = [];
        foreach ($query->getResult() as $key => $item) {

            $del_confirm = "'Hapus item ini?'";
            $view = '<a href="' . site_url('MFPartProduk/detailPartProduct/' . $item->id) . '" title="View"><i class="far fa-file-alt"></i></a>';
            $edit = ' <a href="' . site_url('MFPartProduk/editPartProduct/' . $item->id) . '" title="Edit"><i class="far fa-edit"></i></a>';
            $del = ' <a href="' . site_url('mfpartproduk/delPart/' . $item->id) . '" title="Hapus" onclick="return confirm('.$del_confirm.')"><i class="far fa-trash-alt"></i></a>';

            $added = Time::parse($item->added);
            $updated = Time::parse($item->updated);

            $data[] = [
                $key + 1,
                $item->fgd,
                $item->revisi,
                $item->nama,
                $item->kertas,
                $item->flute,
                $item->metalize,
                (int)$item->panjang . ' x ' . (int)$item->lebar . ' x ' . (int)$item->tinggi,
                $this->common->dateFormat($item->added),
                $item->added_by,
                ($added->equals($updated)) ? '' : $this->common->dateFormat($item->updated),
                $item->updated_by,
                $view . $edit . $del
            ];
        }

        $response = [
            'success' => true,
            'data' => $data
        ];

        return $this->response->setJSON($response);
	}

    public function apiGetByProduct($id_produk)
    {
        $ids_part = (new \App\Models\MFKelompokProdukModel())->getIdsPart($id_produk);

        if(count($ids_part) == 0) {
            return $this->response->setJSON(['success' => true, 'data' => []]);
        }

        $query = $this->model->getByIds($ids_part);

        $results = [];
        foreach($query->getResult() as $key => $row) {

            $added = Time::parse($row->added);
            $updated = Time::parse($row->updated);

            $confirm = "'Hapus item ini?'";
            $results[] = [
                $key + 1,
                $row->fgd,
                $row->revisi,
                $row->nama,
                (new \App\Models\MFJenisKertasModel())->getNama($row->kertas),
                (new \App\Models\MFJenisFluteModel())->getNama($row->flute),
                $row->metalize,
                (int)$row->panjang . 'x' . (int)$row->lebar . 'x' . (int)$row->tinggi,
                $this->common->dateFormat($row->added),
                $row->added_by,
                ($added->equals($updated)) ? '' : $this->common->dateFormat($row->updated),
                $row->updated_by,
                '<a title="Hapus" href="'.site_url('MFProduk/delItemKelProduk/' . $id_produk . '/' . $row->id).'" onclick="return confirm('.$confirm.')" href="#"><i class="far fa-trash-alt"></i></a>'
            ];
        }

        return $this->response->setJSON(['success' => true, 'data' => $results]);
    }

	public function apiGetById()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$id = $this->request->getPost('id');
		$data = $this->model->getById($id);

		$warna_model = new \App\Models\MFProdukWarnaModel();
		$data->backside_colors = $warna_model->getByProdID($id, 'B');
		$data->frontside_colors = $warna_model->getByProdID($id, 'F');

		$data->finishing = (new \App\Models\MFProdukFinishingModel())->getByProdID($id);
		$data->khusus = (new \App\Models\MFProdukKhususModel())->getByProdID($id);
		$data->manual = (new \App\Models\MFProdukManualModel())->getByProdID($id);
		
		$response = [
			'success' => (null !== $this->model->getById($id)) ? true : false,
			'data' => $data
		];

		return $this->response->setJSON($response);
	}

	public function apiAddProcess()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfpartproduk');
		}

		$data = $this->request->getPost();
		$id = $this->model->idGenerator();
		$data['id'] = $id;
		$data['fgd'] = $this->model->fgdGenerator();
		$data['revisi'] = 0;
		$data['added_by'] = current_user()->UserID;
        $data['aktif'] = 'Y';

        $data['nama'] = strtoupper($data['nama']);

        $file = $this->request->getFile('file_dokcr');
        $data['file_dokcr'] = $file->getName();

        $reference_link = $data['ref'];
        $id_produk = $data['id_produk'];
        unset($data['ref']);
        unset($data['id_produk']);

        $filedokcr_errors = [];

        if( $file->getName() != '' ) {
            if( $file->isValid() &&
                $file->getName() !== '' &&
                ($file->getSize() <= $this->filedokcr_max_size) &&
                in_array($file->getExtension(), $this->filedokcr_extension) &&
                in_array($file->getMimeType(), $this->filedokcr_mime_type)
            ) {
                $rev_format = str_pad($data['revisi'], 3, '0', STR_PAD_LEFT);
                $dokcr_filename = 'DOKCR_' . $data['fgd'] . '_' . $rev_format . '.' . $file->getExtension();
                $file->move( WRITEPATH . 'uploads/file_dokcr',  $dokcr_filename);
                $data['file_dokcr'] = $dokcr_filename;
            } else {
                if( ! $file->isValid() ) {
                    $filedokcr_errors[] = 'Dokumen dokcr tidak valid';
                }
                if($file->getSize() > $this->filedokcr_max_size) {
                    $filedokcr_errors[] = 'Ukuran dokcr harus tidak lebih dari ' . $this->filedokcr_max_size;
                }
                if( ! in_array($file->getExtension(), $this->filedokcr_extension) ) {
                    $filedokcr_errors[] = 'Ekstensi dokcr harus diantara ' . implode(', ', $this->filedokcr_extension);
                }
                if( ! in_array($file->getMimeType(), $this->filedokcr_mime_type) ) {
                    $filedokcr_errors[] = 'MimeType dokcr harus diantara ' . implode(', ', $this->filedokcr_mime_type);
                }
            }
        }

        $data_sisi = [
            'id_part' => $id,
            'sisi' => 1,
            'frontside' => 0,
            'backside' => 0,
            'aktif' => 'Y',
            'added_by' => current_user()->UserID
        ];

        $technical_draw = true;
        if($data['technical_draw'] == 'Y' && array_key_exists('no_dokumen', $data) && $data['no_dokumen'] == '') {
            $technical_draw = false;
        }

        if($technical_draw && $this->model->insert($data, false) && count($filedokcr_errors) == 0) {

            $sisi_model = (new \App\Models\MFSisiProdukModel())->insert($data_sisi);

            // Masukkan ke kelompok produk
            if($reference_link != '' && $id_produk != '') {
                $this->insertToProduct($id_produk, $id);
                $redirect_url = site_url('partproduk/edit/' . $id . '?id_produk=' . $id_produk);
            } else {
                $redirect_url = site_url('partproduk/edit/' . $id);
            }

            session()->setFlashdata('success', 'Part produk berhasil ditambahkan');

            return $this->response->setJSON([
                'success' => true,
                'msg' => 'Part produk berhasil ditambahkan.',
                'redirect_url' => $redirect_url
            ]);
        } else {
            $errors = $this->model->errors();
            if( ! $technical_draw ) {
                $errors['no_dokumen'] = 'No dokumen wajib diisi';
            }

            return $this->response->setJSON([
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $errors) . '</p>',
                'data' => $data,
            ]);
        }
	}

    private function insertToProduct($id_produk, $id_part)
    {
        $data = [
            'id_produk' => $id_produk,
            'id_part' => $id_part,
            'utama' => 'Y',
            'aktif' => 'Y',
            'added_by' => current_user()->UserID
        ];

        return (new \App\Models\MFKelompokProdukModel())->insert($data);
    }

    public function apiAddToProduct()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('mfpartproduk');
        }

        $id_produk = $this->request->getPost('id_produk');
        $id_part = $this->request->getPost('id_part');

        if($this->insertToProduct($id_produk, $id_part)) {
            $response = [
                'success' => true,
                'msg' => 'Part produk berhasil ditambahkan.'
            ];
        } else {
            $response = [
                'success' => false,
                'msg' => 'Part produk gagal ditambahkan.'
            ];
        }

        return $this->response->setJSON($response);
    }

    public function apiDelFromProduct()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('mfpartproduk');
        }

        $id_produk = $this->request->getPost('id_produk');
        $id_part = $this->request->getPost('id_part');

        $query = (new \App\Models\MFKelompokProdukModel())->where('id_produk', $id_produk)
            ->where('id_part', $id_part)
            ->delete();

        if($query) {
            $response = [
                'success' => true,
                'msg' => 'Part produk berhasil dihapus.'
            ];
        } else {
            $response = [
                'success' => false,
                'msg' => 'Part produk gagal dihapus.'
            ];
        }

        return $this->response->setJSON($response);
    }

	public function apiEditProcess()
	{
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('mfpartproduk');
        }

        $data = $this->request->getPost();

        if(array_key_exists('is_revision', $data)) {
            $existing_id = $data['id'];

            $id = $this->model->idGenerator();
            $data['id'] = $id;
            $data['added_by'] = current_user()->UserID;
            $data['revisi'] = $this->model->revGenerator($data['fgd']);

        } else {
            $id = $data['id'];
            unset($data['id']);
            $data['revisi'] = 0;
            $data['updated_by'] = current_user()->UserID;
        }

        $data['nama'] = strtoupper($data['nama']);

        $file = $this->request->getFile('file_dokcr');
        $data['file_dokcr'] = $file->getName();

        $filedokcr_errors = [];

        if( $file->getName() != '' ) {
            if( $file->isValid() &&
                $file->getName() !== '' &&
                ($file->getSize() <= $this->filedokcr_max_size) &&
                in_array($file->getExtension(), $this->filedokcr_extension) &&
                in_array($file->getMimeType(), $this->filedokcr_mime_type)
            ) {
                if(array_key_exists('is_revision', $data)) {
                    $rev_format = str_pad($data['revisi'], 3, '0', STR_PAD_LEFT);
                    $dokcr_filename = 're_DOKCR_' . $data['fgd'] . '_' . $rev_format . '.' . $file->getExtension();
                    $data['file_dokcr'] = $dokcr_filename;
                } else {
                    $rev_format = str_pad($data['revisi'], 3, '0', STR_PAD_LEFT);
                    $dokcr_filename = 'DOKCR_' . $data['fgd'] . '_' . $rev_format . '.' . $file->getExtension();
                    $file->move(WRITEPATH . 'uploads/file_dokcr', $dokcr_filename, true);
                    $data['file_dokcr'] = $dokcr_filename;
                }
            } else {
                if( ! $file->isValid() ) {
                    $filedokcr_errors[] = 'Dokumen dokcr tidak valid';
                }
                if($file->getSize() > $this->filedokcr_max_size) {
                    $filedokcr_errors[] = 'Ukuran dokcr harus tidak lebih dari ' . $this->filedokcr_max_size;
                }
                if( ! in_array($file->getExtension(), $this->filedokcr_extension) ) {
                    $filedokcr_errors[] = 'Ekstensi dokcr harus diantara ' . implode(', ', $this->filedokcr_extension);
                }
                if( ! in_array($file->getMimeType(), $this->filedokcr_mime_type) ) {
                    $filedokcr_errors[] = 'MimeType dokcr harus diantara ' . implode(', ', $this->filedokcr_mime_type);
                }
            }
        } else {
            if(array_key_exists('is_revision', $data)) {
                if (array_key_exists('ex_file_dokcr', $data)) {
                    $ext_file = explode('.', $data['ex_file_dokcr']);
                    $newfilename = 'DOKCR_' . $data['fgd'] . '_' . str_pad($data['revisi'], 3, '0', STR_PAD_LEFT) . '.' . end($ext_file);
                    $ex_file = WRITEPATH . 'uploads/file_dokcr/' . $data['ex_file_dokcr'];
                    $copy_file = WRITEPATH . 'uploads/file_dokcr/' . $newfilename;
                    if(!copy($ex_file, $copy_file)) {
                        $data['file_dokcr'] = $data['ex_file_dokcr'];
                    } else {
                        $data['file_dokcr'] = $newfilename;
                    }
                    unset($data['ex_file_dokcr']);
                }
            } else {
                if(array_key_exists('ex_file_dokcr', $data)) {
                    $data['file_dokcr'] = $data['ex_file_dokcr'];
                    unset($data['ex_file_dokcr']);
                }
            }
        }

        $technical_draw = true;
        if($data['technical_draw'] == 'Y' && array_key_exists('no_dokumen', $data) && $data['no_dokumen'] == '') {
            $technical_draw = false;
        }

        if(array_key_exists('is_revision', $data)) {
            if($technical_draw && $this->model->insert($data, false) && count($filedokcr_errors) == 0) {

                $data_sisi = $this->cloneSelectSisi($existing_id, $id);
                $insert_sisi = $this->cloneInsertSisi($data_sisi);

                session()->setFlashdata('success', 'Revisi baru berhasil ditambahkan.');
                return $this->response->setJSON([
                    'success' => true,
                    'msg' => 'Revisi baru berhasil ditambahkan.',
                    'redirect_url' => site_url('partproduk/edit/' . $id)
                ]);
            } else {
                $errors = array_merge($this->model->errors(), $filedokcr_errors);
                return $this->response->setJSON([
                    'success' => false,
                    'msg' => '<p>' . implode('</p><p>', $errors) . '</p>',
                    'data' => $data
                ]);
            }
        } else {
            if($technical_draw && count($filedokcr_errors) == 0 && $this->model->updatePart($id, $data)) {

                session()->setFlashdata('success', 'Part produk berhasil diubah.');
                return $this->response->setJSON([
                    'success' => true,
                    'msg' => 'Part produk berhasil diubah.',
                    'redirect_url' => site_url('partproduk/edit/' . $id)
                ]);
            } else {
                $errors = array_merge($this->model->errors(), $filedokcr_errors);
                return $this->response->setJSON([
                    'success' => false,
                    'msg' => '<p>' . implode('</p><p>', $errors) . '</p>',
                    'data' => $data
                ]);
            }
        }
	}

    private function cloneSelectSisi($existing_id_part, $new_id_part)
    {
        $query_sisi = (new \App\Models\MFSisiProdukModel())->getAllSisiByPart($existing_id_part);

        if($query_sisi->getNumRows() > 0) {
            $data_sisi = [];
            foreach($query_sisi->getResult() as $row) {
                $query_colors = (new \App\Models\MFProdukWarnaModel())->where('id_sisi', $row->id)->findAll();
                $query_manual = (new \App\Models\MFProdukManualModel())->where('id_sisi', $row->id)->findAll();
                $query_finishing = (new \App\Models\MFProdukFinishingModel())->where('id_sisi', $row->id)->findAll();
                $query_khusus = (new \App\Models\MFProdukKhususModel())->where('id_sisi', $row->id)->findAll();
                $data_sisi[] = [
                    'id_part' => $new_id_part,
                    'sisi' => $row->sisi,
                    'frontside' => $row->frontside,
                    'backside' => $row->backside,
                    'special_req' => $row->special_req,
                    'aktif' => $row->aktif,
                    'added_by' => current_user()->UserID,
                    'colors' => $query_colors,
                    'manual' => $query_manual,
                    'finishing' => $query_finishing,
                    'khusus' => $query_khusus,
                ];
            }
        } else {
            $data_sisi = [
                [
                    'id_part' => $new_id_part,
                    'sisi' => 1,
                    'frontside' => 0,
                    'backside' => 0,
                    'aktif' => 'Y',
                    'added_by' => current_user()->UserID,
                    'colors' => [],
                    'manual' => [],
                    'finishing' => [],
                    'khusus' => [],
                ]
            ];
        }

        return $data_sisi;
    }

    private function cloneInsertSisi(array $data)
    {
        $model = new \App\Models\MFSisiProdukModel();
        $model_colors = new \App\Models\MFProdukWarnaModel();
        $model_manual = new \App\Models\MFProdukManualModel();
        $model_finishing = new \App\Models\MFProdukFinishingModel();
        $model_khusus = new \App\Models\MFProdukKhususModel();

        $results = [];

        foreach ($data as $row) {
            $colors = $row['colors'];
            $manual = $row['manual'];
            $finishing = $row['finishing'];
            $khusus = $row['khusus'];
            unset($row['colors']);
            unset($row['manual']);
            unset($row['finishing']);
            unset($row['khusus']);

            if($model->insert($row)) {
                $id = $model->getInsertID();
                if(count($colors) > 0) {
                    $data_colors = [];
                    foreach ($colors as $item) {
                        $data_colors[] = [
                            'id_sisi' => $id,
                            'posisi' => $item['posisi'],
                            'tinta' => $item['tinta'],
                            'aktif' => $item['aktif'],
                            'added_by' => current_user()->UserID,
                        ];
                    }
                    $insert_colors = $model_colors->insertBatch($data_colors);
                } else {
                    $insert_colors = true;
                }

                if(count($manual) > 0) {
                    $data_manual = [];
                    foreach ($manual as $item) {
                        $data_manual[] = [
                            'id_sisi' => $id,
                            'proses' => $item['proses'],
                        ];
                    }
                    $insert_manual = $model_manual->insertBatch($data_manual);
                } else {
                    $insert_manual = true;
                }

                if(count($finishing) > 0) {
                    $data_finishing = [];
                    foreach ($finishing as $item) {
                        $data_finishing[] = [
                            'id_sisi' => $id,
                            'proses' => $item['proses'],
                        ];
                    }
                    $insert_finishing = $model_finishing->insertBatch($data_finishing);
                } else {
                    $insert_finishing = true;
                }

                if(count($khusus) > 0) {
                    $data_khusus = [];
                    foreach ($khusus as $item) {
                        $data_khusus[] = [
                            'id_sisi' => $id,
                            'proses' => $item['proses'],
                        ];
                    }
                    $insert_khusus = $model_khusus->insertBatch($data_khusus);
                } else {
                    $insert_khusus = true;
                }

                $results[] = [
                    'success' => true,
                    'id' => $id,
                    'colors' => [
                        'success' => $insert_colors,
                        'rows' => count($colors)
                    ],
                    'manual' => [
                        'success' => $insert_manual,
                        'rows' => count($manual)
                    ],
                    'finishing' => [
                        'success' => $insert_finishing,
                        'rows' => count($finishing)
                    ],
                    'khusus' => [
                        'success' => $insert_khusus,
                        'rows' => count($khusus)
                    ],
                ];
            } else {
                $results[] = [
                    'success' => false,
                    'id' => null,
                    'colors' => null,
                    'manual' => null,
                    'finishing' => null,
                    'khusus' => null,
                ];
            }
        }

        return $results;
    }

	private function productColors($colors, $prod_id, $initial_position)
	{
		if(!is_array($colors) || count($colors) == 0) {
			return [];
		}

		return array_map(function($item) use($prod_id, $initial_position) {
			return [
				'id_produk' => $prod_id,
				'posisi' => $initial_position,
				'tinta' => $item
			];
		}, $colors);
	}

	private function productProcess($process, $prod_id)
	{
		if(!is_array($process) || count($process) == 0) {
			return [];
		}

		return array_map(function($item) use($prod_id) {
			return [
				'id_produk' => $prod_id,
				'proses' => $item
			];
		}, $process);
	}
}