<?php

namespace App\Controllers;

use App\Models\SalesModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Sales extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new SalesModel();
	}

    /**
     * @return string
     */
    public function index(): string
	{
		$this->breadcrumbs->add('Dashbor', '/');
        $this->breadcrumbs->add('Data Sales', '/sales');

		return view('Sales/main', [
			'page_title' => 'Data Sales',
			'breadcrumbs' => $this->breadcrumbs->render(),
            'main_menu' => (new \App\Libraries\Menu())->render()
		]);
	}

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint GET /api/master/sales
     */
    public function apiGetAll(): ResponseInterface
	{
        $navigation = new \App\Libraries\Navigation();

        $query = $this->model->getSales();

		$data = [];
		foreach ($query as $key => $value) {

            $detail = $navigation->button('detail', ['data-id' => $value->SalesID]);
            $edit = $navigation->button('edit', ['data-id' => $value->SalesID, 'data-nama' => $value->SalesName, 'data-nik' => $value->NIK, 'data-aktif' => $value->FlagAktif.'|A,N']);
            $hapus = $navigation->button('delete', [
                'data-id' => $value->SalesID,
                'href' => site_url('sales/delete/' . $value->SalesID)
            ]);
		
			$data[] = [
				$key + 1,
				$value->SalesID,
				$value->SalesName,
				$value->NIK,
				$value->FlagAktif,
				$detail . $edit . $hapus
			];
		}

		return $this->response->setJSON($data);
	}

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \Exception
     *
     * Endpoint GET /api/master/sales/$1
     */
    public function apiGetById($id): ResponseInterface
	{
		$modified = $this->request->getGet('modified') == 'yes';

		$query = $this->model->getById($id);

		if (count($query) == 1) {
			$data = $query[0];

			if ($modified) {
				$data = [];
				foreach ($query[0] as $key => $value) {
					if ($key == 'FlagAktif') {
						$data[$key] = ($value == 'A') ? 'Ya' : 'Tidak';
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
     * Endpoint POST /api/master/sales
     */
    public function apiAddProcess(): ResponseInterface
	{
		$data = $this->request->getPost();
		$data['SalesID'] = $this->model->getMaxId() + 1;

		if ($this->model->insert($data, false)) {
			$msg = 'Data berhasil ditambahkan';
			session()->setFlashData('success', $msg);
			$response = [
				'success' => true,
				'msg' => $msg,
				'data' => [
					'SalesID' => $data['SalesID'],
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
     * Endpoint PUT /api/master/sales
     */
    public function apiEditProcess(): ResponseInterface
	{
        $data = $this->request->getRawInput();
        $id = $data['SalesID'];
        unset($data['SalesID']);

    	$query = $this->model->getById($id);

		if ($this->model->updateById($id, $data)) {
			$msg = 'Data berhasil diupdate';
			$response = [
				'success' => true,
				'msg' => $msg,
				'data' => [
					'SalesID' => $id,
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
        $query = $this->model->getSales();

        $data = [];
        foreach ($query as $row) {
            $data[] = [
                'id' => $row->SalesID,
                'name' => $row->SalesName
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}
