<?php

namespace App\Controllers;

use App\Models\MFJenisKertasModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class MFJenisKertas extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new MFJenisKertasModel();
	}

    /**
     * @return string
     */
    public function index(): string
	{
		return view('MFJenisKertas/main', [
			'page_title' => 'Data Jenis Kertas MF',
            'breadcrumbs' => $this->common->breadcrumbs(uri_string(true)),
            'main_menu' => (new \App\Libraries\Menu())->render()
		]);
	}

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint GET /api/master/kertas
     */
    public function apiGetAll(): ResponseInterface
	{
        $access = $this->common->getAccess(uri_string(true));
        $navigation = new \App\Libraries\Navigation();
        $navigation->setAccess($access);

		$query = $this->model->getMFJenisKertas();

		$data = [];
		foreach ($query as $key => $value) {

			$CreateDate = (Time::parse($value->added))->toDateTimeString();

            $detail = $navigation->button('detail', [
                'data-id' => $value->id,
            ]);
            $edit = $navigation->button('edit', [
                'data-id' => $value->id,
                'data-nama' => $value->nama,
                'data-harga' => $value->harga,
                'data-berat' => $value->berat,
                'data-added' => $CreateDate,
                'data-aktif' => $value->aktif . '|Y,T',
            ]);
            $hapus = $navigation->button('delete', [
                'href' => site_url('jeniskertas/delete/' . $value->id),
            ]);
		
			$data[] = [
				$key + 1,
				$value->id,
                $this->common->dateFormat($CreateDate),
				$value->nama,
				(int)$value->berat,
				number_format($value->harga,2,",","."),
				$value->aktif,
				$this->common->dateFormat($value->added),
				$value->added_by,
                $this->common->dateFormat($value->updated),
				$value->updated_by,
				$detail . $edit . $hapus
			];
		}

		return $this->response->setJSON($data);
	}

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @param $id
     *
     * Endpoint GET /api/master/kertas/$1
     */
    public function apiGetById($id): ResponseInterface
	{
		$modified = $this->request->getPost('modified') ?? false;

		$query = $this->model->getById($id);

		if (count($query) == 1) {
			$data = $query[0];

			if ($modified) {
				$data = [];
				foreach ($query[0] as $key => $value) {
					if ($key == 'aktif') {
						$data[$key] = ($value == 'Y') ? 'Aktif' : 'Nonaktif';
					} elseif ($key == 'added' || $key == 'updated') {
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
     * Endpoint POST /api/master/kertas
     */
    public function apiAddProcess(): ResponseInterface
	{
		$data = $this->request->getPost();
		$data['added_by'] = current_user()->UserID;

		if ($this->model->insert($data)) {
			$msg = 'Data berhasil ditambahkan';
			session()->setFlashData('success', $msg);
			$response = [
				'success' => true,
				'msg' => $msg,
				'data' => [
					'id' => $this->model->insertID(),
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
     * @param $raw_input
     * @return array
     */
    public function getPut($raw_input): array
    {
        $input_string = $raw_input[array_keys($raw_input)[0]];

        preg_match('#\{(.*?)\}#', $input_string, $match);

        $json_string = '{' . $match[1] . '}';

        return (array) json_decode($json_string);
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint PUT /api/master/kertas
     */
    public function apiEditProcess(): ResponseInterface
	{
        $data = $this->request->getRawInput();

		$data['updated_by'] = current_user()->UserID;
		$id = $data["id"];
		unset($data["id"]);

		if ($this->model->updateById($id, $data)) {
			$msg = 'Data berhasil diupdate';
			$response = [
				'success' => true,
				'msg' => $msg,
				'data' => [
					'id' => $id,
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
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
	{
		if ($this->model->deleteById($id)) {
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
        $query = $this->model->getMFJenisKertas();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->nama
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}
