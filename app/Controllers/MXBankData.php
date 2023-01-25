<?php

namespace App\Controllers;

use App\Models\MXBankDataModel;
use CodeIgniter\Database\Config;
use Config\Database;
use Config\Services;

class MXBankData extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new MXBankDataModel();
    }

    public function apiGetAll()
    {
        $jenisproduk = $this->request->getPost('jenisproduk');
        $query = $this->model->getByJenisProduk($jenisproduk);

//        return $this->response->setJSON($query->getResult());

        $results = [];
        foreach ($query->getResult() as $key => $row) {

            $grab_btn = '<button data-ID="'.$row->ID.'" type="button" name="load-btn" class="btn btn-primary btn-sm load-produk-btn">Load</button>';

            $results[] = [
                $key + 1,
                $row->NoProspek,
                $row->Alt,
                $row->NamaProduk,
                $row->NamaMaterial1,
                $row->NamaMaterial2,
                $row->NamaMaterial3,
                $row->NamaMaterial4,
                $row->JenisTinta,
                $row->TintaKhusus,
                $row->KetJenisAdhesive,
                $grab_btn
            ];
        }

        return $this->response->setJSON($results);
    }

    public function getById($id)
    {
        $query = $this->model->select('MX_BankData.*, Material1.Nama as NamaMaterial1, Material2.Nama as NamaMaterial2, Material3.Nama as NamaMaterial3, Material4.Nama as NamaMaterial4, MX_Adhesive.nama as NamaAdhesive')
            ->join('MX_Material Material1', 'MX_BankData.Material1 = Material1.ID', 'left')
            ->join('MX_Material Material2', 'MX_BankData.Material2 = Material2.ID', 'left')
            ->join('MX_Material Material3', 'MX_BankData.Material3 = Material3.ID', 'left')
            ->join('MX_Material Material4', 'MX_BankData.Material4 = Material4.ID', 'left')
            ->join('MX_Adhesive', 'MX_BankData.JenisAdhesive = MX_Adhesive.id')
            ->where('MX_BankData.ID', $id)
            ->get();

        return $this->response->setJSON([
            'success' => true,
            'data' => $query->getResult()[0]
        ]);
    }
}