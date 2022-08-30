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

	// public function index2() {
	// 	dd($this->model->getByFgdNama2('c'));
	// }

	public function index()
	{

//		$segmen_model = new \App\Models\SegmenModel();
//		$customer_model = new \App\Models\CustomerModel();
//		$sales_model = new \App\Models\SalesModel();
//		$tujuankirim_model = new \App\Models\MFTujuanKirimModel();
//		$jeniskertas_model = new \App\Models\MFJenisKertasModel();
//		$jenistinta_model = new \App\Models\MFJenisTintaModel();
//		$jenisflute_model = new \App\Models\MFJenisFluteModel();
//		$packing_model = new \App\Models\MFPackingModel();
//		$finishing_model = new \App\Models\MFProsesFinishingModel();
//		$manual_model = new \App\Models\MFProsesManualModel();
//		$khusus_model = new \App\Models\MFProsesKhususModel();
		return view('MFPartProduk/cari', [
			'page_title' => 'Cari Part Produk MF',
//			'opsi_segmen' => $segmen_model->getAll(),
//			'opsi_customer' => $customer_model->getOpsi(),
//			'opsi_sales' => $sales_model->getOpsi(),
			// 'opsi_sales' => [],
//			'opsi_tujuankirim' => $tujuankirim_model->getOpsi(),
//			'opsi_kertas' => $tujuankirim_model->getOpsi(),
//			'opsi_jeniskertas' => $jeniskertas_model->getOpsi(),
//			'opsi_jenistinta' => $jenistinta_model->getOpsi(),
//			'opsi_jenisflute' => $jenisflute_model->getOpsi(),
//			'opsi_innerpack' => $packing_model->getOpsi('Inner'),
//			'opsi_outerpack' => $packing_model->getOpsi('Outer'),
//			'opsi_deliverypack' => $packing_model->getOpsi('Delivery'),
//			'opsi_finishing' => $finishing_model->getOpsi(),
//			'opsi_manual' => $manual_model->getOpsi(),
//			'opsi_khusus' => $khusus_model->getOpsi(),
		]);
	}

	public function addPartProduct()
	{

//		$segmen_model = new \App\Models\SegmenModel();
//		$customer_model = new \App\Models\CustomerModel();
//		$sales_model = new \App\Models\SalesModel();
		$tujuankirim_model = new \App\Models\MFTujuanKirimModel();
		$jeniskertas_model = new \App\Models\MFJenisKertasModel();
		$jenistinta_model = new \App\Models\MFJenisTintaModel();
		$jenisflute_model = new \App\Models\MFJenisFluteModel();
		$packing_model = new \App\Models\MFPackingModel();
//		$finishing_model = new \App\Models\MFProsesFinishingModel();
//		$manual_model = new \App\Models\MFProsesManualModel();
//		$khusus_model = new \App\Models\MFProsesKhususModel();
		return view('MFPartProduk/input', [
			'page_title' => 'Input Part Produk MF',
//			'opsi_segmen' => $segmen_model->getAll(),
//			'opsi_customer' => $customer_model->getOpsi(),
//			'opsi_sales' => $sales_model->getOpsi(),
			// 'opsi_sales' => [],
			'opsi_tujuankirim' => $tujuankirim_model->getOpsi(),
			'opsi_kertas' => $tujuankirim_model->getOpsi(),
			'opsi_jeniskertas' => $jeniskertas_model->getOpsi(),
			'opsi_jenistinta' => $jenistinta_model->getOpsi(),
			'opsi_jenisflute' => $jenisflute_model->getOpsi(),
			'opsi_innerpack' => $packing_model->getOpsi('Inner'),
			'opsi_outerpack' => $packing_model->getOpsi('Outer'),
			'opsi_deliverypack' => $packing_model->getOpsi('Delivery'),
//			'opsi_finishing' => $finishing_model->getOpsi(),
//			'opsi_manual' => $manual_model->getOpsi(),
//			'opsi_khusus' => $khusus_model->getOpsi(),
		]);
	}

    public function editPartProduct($id)
    {
        $data = $this->model->getById($id);

        $tujuankirim_model = new \App\Models\MFTujuanKirimModel();
        $jeniskertas_model = new \App\Models\MFJenisKertasModel();
        $jenistinta_model = new \App\Models\MFJenisTintaModel();
        $jenisflute_model = new \App\Models\MFJenisFluteModel();
        $packing_model = new \App\Models\MFPackingModel();
        return view('MFPartProduk/edit', [
            'page_title' => 'Input Part Produk MF',
            'data' => $data,
            'opsi_tujuankirim' => $tujuankirim_model->getOpsi(),
            'opsi_kertas' => $tujuankirim_model->getOpsi(),
            'opsi_jeniskertas' => $jeniskertas_model->getOpsi(),
            'opsi_jenistinta' => $jenistinta_model->getOpsi(),
            'opsi_jenisflute' => $jenisflute_model->getOpsi(),
            'opsi_innerpack' => $packing_model->getOpsi('Inner'),
            'opsi_outerpack' => $packing_model->getOpsi('Outer'),
            'opsi_deliverypack' => $packing_model->getOpsi('Delivery'),
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

    public function apiAddSisi()
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

        $data['id'] = random_string('basic');
        $data['added_by'] = session()->get('UserID');

        if($model->insert($data, false)) {
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

            $model_warna->insertBatch($data_colors);

            if(array_key_exists('manualcolor', $data)) {
                $data_manual = [];
                for($i = 0;$i < count($data['manualcolor']);$i++) {
                    $data_manual[] = [
                        'id_sisi' => $data['id'],
                        'proses' => $data['manualcolor'][$i]
                    ];
                }
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

//        return $this->response->setJSON($data);

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

    public function apiAllSisi($id)
    {
        $query = (new \App\Models\MFSisiProdukModel())->getAllSisiByPart($id);

        if($query->getNumRows() > 0) {
            $data = [];
            foreach ($query->getResult() as $row) {
                $del_confirm = "'Hapus item ini?'";
                $view = '<a href="#" title="View" class="view-sisi" data-id="' . $row->id . '"><i class="far fa-file-alt"></i></a>';
                $edit = ' <a href="#" title="Edit" class="edit-sisi" data-id="' . $row->id . '"><i class="far fa-edit"></i></a>';
                $del = ' <a href="' . site_url('mfpartproduk/delSisi/' . $row->id) . '" title="Hapus" onclick="return confirm('.$del_confirm.')"><i class="far fa-trash-alt"></i></a>';

                $data[] = [
                    $row->sisi,
                    $row->frontside,
                    $row->backside,
                    $row->special_req,
                    $row->added,
                    $row->added_by,
                    $row->updated,
                    $row->updated_by,
                    $view . $edit . $del
                ];
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

        if($model->where('id', $id)->delete()) {
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

	public function productSearch()
	{
		$keyword = $this->request->getPost('keyword');
		$query = $this->model->getByFgdNama("$keyword");
		//dd($query);
		//exit;


		$data = [];
		foreach($query as $key => $val) {
			$edit_btn = '<button type="button" class="btn btn-sm btn-success edit-rev-item mr-2" data-id="'.$val->id.'">Edit</button>';
			$revisi_btn = '<button type="button" class="btn btn-sm btn-danger rev-item" data-id="'.$val->id.'">Revisi</button>';
			$data[] = [
				$key + 1,
				$val->fgd,
				$val->revisi,
				$val->nama_produk,
				$val->segmen,
				// $val->pemesan,
				$val->customer,
				$val->sales,
				$val->added,
				$val->added_by,
				$val->updated,
				$val->updated_by,
				$edit_btn . $revisi_btn
			];
		}

		$response = [
			'success' => true,
			'data' => $data
		];

		return $this->response->setJSON($response);
	}

	public function apiGetAll()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

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

    public function tes() {
        $fields_req = ['nama', 'tujuan_penggunaan', 'panjang', 'lebar', 'tinggi', 'kertas', 'flute', 'inner_pack', 'jum_innerpack', 'outer_pack', 'jam_outerpack'];
        $validationRules = [];
        $validationMessages = [];
        foreach ($fields_req as $field) {
            $validationRules[$field] = 'required';
            $validationMessages[$field]['required'] = 'Field ' . $field . ' harus diisi';
        }

        dd($validationMessages);
    }

	public function apiAddProcess()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfpartproduk');
		}

		$data = $this->request->getPost();
//        $files = $this->request->getFiles();
		$id = $this->model->idGenerator();
		$data['id'] = $id;
		$data['fgd'] = $this->model->fgdGenerator();
		$data['revisi'] = 0;
		$data['added_by'] = current_user()->UserID;

        $data['metalize'] = 'T';

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
                $dokcr_filename = $file->getRandomName();
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

//        return $this->response->setJSON([
//            'data' => $data,
//            'file_meta' => [
//                'isValid' => $file->isValid(),
//                'getName' => $file->getName(),
//                'getSize' => $file->getSize(),
//                'getExtension' => $file->getExtension(),
//                'getMimeType' => $file->getMimeType()
//            ],
//        ]);

        if($this->model->insert($data, false) && count($filedokcr_errors) == 0) {
            return $this->response->setJSON([
                'success' => true,
                'msg' => 'Part produk berhasil ditambahkan.',
                'redirect_url' => site_url('mfpartproduk/detailPartProduct/' . $data['id'])
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

	public function apiEditRevision()
	{
		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$data = $this->request->getPost();
		$data['updated_by'] = current_user()->UserID;
		unset($data['fgd']);

		if(array_key_exists('frontside_colors', $data) || array_key_exists('backside_colors', $data)) {
			$data_colors = [];
			if(array_key_exists('frontside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['frontside_colors'], $data['id'], 'F'));
			}
			if(array_key_exists('backside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['backside_colors'], $data['id'], 'B'));
			}
			if(count($data_colors) > 0) {
				$color_model = new \App\Models\MFProdukWarnaModel();
				$update_colors = $color_model->reInsert($data_colors);
			}
		}

		if(array_key_exists('finishing', $data)) {
			$data_finishing = $this->productProcess($data['finishing'], $data['id']);
			if(count($data_finishing) > 0) {
				$finishing_model = new \App\Models\MFProdukFinishingModel();
				$update_finishing = $finishing_model->reInsert($data_finishing);
			}
		}

		if(array_key_exists('manual', $data)) {
			$data_manual = $this->productProcess($data['manual'], $data['id']);
			if(count($data_manual) > 0) {
				$manual_model = new \App\Models\MFProdukManualModel();
				$update_manual = $manual_model->reInsert($data_manual);
			}
		}

		if(array_key_exists('khusus', $data)) {
			$data_khusus = $this->productProcess($data['khusus'], $data['id']);
			if(count($data_khusus) > 0) {
				$khusus_model = new \App\Models\MFProdukKhususModel();
				$update_khusus = $khusus_model->reInsert($data_khusus);
			}
		}

		// return $this->response->setJSON(['data' => $data]);

		$main_data = $this->model->save($data);

		if(isset($update_colors) && !$update_colors) {
			array_push($this->errors, 'Data warna gagal diupdate.');
		}
		if(isset($update_finishing) && !$update_finishing) {
			array_push($this->errors, 'Data finishing gagal diupdate.');
		}
		if(isset($update_manual) && !$update_manual) {
			array_push($this->errors, 'Data manual gagal diupdate.');
		}
		if(isset($update_khusus) && !$update_khusus) {
			array_push($this->errors, 'Data khusus gagal diupdate.');
		}
		if(!$main_data) {
			$this->errors = array_merge($this->errors, $this->model->errors());
		}

    	if( count($this->errors) > 0 ) {
    		return $this->response->setJSON([
    			'success' => false,
    			'msg' => '<p>' . implode('</p><p>', $this->errors) . '</p>',
    			'data' => null,
    		]);
    	}

    	return $this->response->setJSON([
    		'success' => true,
    		'msg' => 'Data revisi berhasil diupdate',
    		'data' => [
    			'id' => $data['id'],
    		],
    	]);
	}

	public function apiAddRevision() {

		if ($this->request->getMethod() !== 'post') {
			return redirect()->to('mfproduk');
		}

		$data = $this->request->getPost();
		$id = $this->model->idGenerator();
		$data['id'] = $id;
		 $data['fgd'] = $this->model->fgdGenerator();
		$data['revisi'] = 1 + $this->model->getLastRev('220600000007')->revisi;
		$data['added_by'] = current_user()->UserID;

		if(array_key_exists('frontside_colors', $data) || array_key_exists('backside_colors', $data)) {
			$data_colors = [];
			if(array_key_exists('frontside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['frontside_colors'], $id, 'F'));
			}
			if(array_key_exists('backside_colors', $data)) {
				$data_colors = array_merge($data_colors, $this->productColors($data['backside_colors'], $id, 'B'));
			}
			if(count($data_colors) > 0) {
				$color_model = new \App\Models\MFProdukWarnaModel();
				$insert_colors = $color_model->insertBatch($data_colors);
			}
		}

		if(array_key_exists('finishing', $data)) {
			$data_finishing = $this->productProcess($data['finishing'], $id);
			if(count($data_finishing) > 0) {
				$finishing_model = new \App\Models\MFProdukFinishingModel();
				$insert_finishing = $finishing_model->insertBatch($data_finishing);
			}
		}

		if(array_key_exists('manual', $data)) {
			$data_manual = $this->productProcess($data['manual'], $id);
			if(count($data_manual) > 0) {
				$manual_model = new \App\Models\MFProdukManualModel();
				$insert_manual = $manual_model->insertBatch($data_manual);
			}
		}

		if(array_key_exists('khusus', $data)) {
			$data_khusus = $this->productProcess($data['khusus'], $id);
			if(count($data_khusus) > 0) {
				$khusus_model = new \App\Models\MFProdukKhususModel();
				$insert_khusus = $khusus_model->insertBatch($data_khusus);
			}
		}

		$main_data = $this->model->insert($data);

		if(isset($insert_colors) && !$insert_colors) {
			array_push($this->errors, 'Data warna gagal diinsert.');
		}
		if(isset($insert_finishing) && !$insert_finishing) {
			array_push($this->errors, 'Data finishing gagal diinsert.');
		}
		if(isset($insert_manual) && !$insert_manual) {
			array_push($this->errors, 'Data manual gagal diinsert.');
		}
		if(isset($insert_khusus) && !$insert_khusus) {
			array_push($this->errors, 'Data khusus gagal diinsert.');
		}
		if(!$main_data) {
			$this->errors = array_merge($this->errors, $this->model->errors());
		}

    	if( count($this->errors) > 0 ) {
    		if(isset($insert_colors) && $insert_colors) {
    			$color_model->deleteByProdID($id);
    		}
    		if(isset($insert_finishing) && $insert_finishing) {
    			$finishing_model->deleteByProdID($id);
    		}
    		if(isset($insert_manual) && $insert_manual) {
    			$manual_model->deleteByProdID($id);
    		}
    		if(isset($insert_khusus) && $insert_khusus) {
    			$khusus_model->deleteByProdID($id);
    		}
    		return $this->response->setJSON([
    			'success' => false,
    			'msg' => '<p>' . implode('</p><p>', $this->errors) . '</p>',
    			'data' => null,
    		]);
    	}

    	return $this->response->setJSON([
    				'success' => true,
    				'msg' => 'Revisi baru berhasil ditambahkan.',
    				'data' => [
    					'id' => $data['id'],
    				],
    			]);
	}

	public function apiEditProcess()
	{
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('mfpartproduk');
        }

        $data = $this->request->getPost();
        $id = $data['id'];
        unset($data['id']);
        $data['revisi'] = 0;
        $data['updated_by'] = current_user()->UserID;

        $data['metalize'] = 'T';

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
                $dokcr_filename = $file->getRandomName();
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
        } else {
            if(array_key_exists('ex_file_dokcr')) {
                $data['file_dokcr'] = $data['ex_file_dokcr'];
                unset($data['ex_file_dokcr']);
            }
        }

        if($this->model->updatePart($id, $data) && count($filedokcr_errors) == 0) {
            return $this->response->setJSON([
                'success' => true,
                'msg' => 'Part produk berhasil diubah.',
                'redirect_url' => site_url('mfpartproduk/detailPartProduct/' . $data['id'])
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

	public function delete($id)
	{
	
		return redirect()->back()
			->with('error', 'Data gagal dihapus');
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

    public function masters()
    {
        $data = (new \App\Models\MFJenisKertasModel())->getOpsi();
        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}
