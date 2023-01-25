<?php

namespace App\Models;

class MXBankDataModel extends \CodeIgniter\Model

{
    protected $table = 'MX_BankData';
    protected $allowedFields = ['Pemesan', 'NamaProduk', 'JenisProduk', 'Material1', 'TebalMat1', 'Material2', 'TebalMat2', 'Material3', 'TebalMat3', 'Material4', 'TebalMat4', 'JenisTinta', 'TintaKhusus', 'JenisAdhesive', 'NoProspek', 'Alt'];

    public function getByJenisProduk($jenisproduk)
    {
        return $this->select('MX_BankData.*, CF.NamaPemesan NamaPemesan, JP.nama KetJenisProduk, M1.Nama as NamaMaterial1, M2.Nama as NamaMaterial2, M3.Nama as NamaMaterial3, M4.Nama as NamaMaterial4, AD.nama KetJenisAdhesive')
            ->join('CustomerFile CF', 'MX_BankData.Pemesan = CF.NoPemesan', 'left')
            ->join('MX_JenisProduk JP', 'MX_BankData.JenisProduk = JP.id', 'left')
            ->join('MX_Material M1', 'MX_BankData.Material1 = M1.ID', 'left')
            ->join('MX_Material M2', 'MX_BankData.Material2 = M2.ID', 'left')
            ->join('MX_Material M3', 'MX_BankData.Material3 = M3.ID', 'left')
            ->join('MX_Material M4', 'MX_BankData.Material4 = M4.ID', 'left')
            ->join('MX_Adhesive AD', 'MX_BankData.JenisAdhesive = AD.id', 'left')
            ->where('MX_BankData.JenisProduk', $jenisproduk)
            ->get();
    }
    public function getByID($id)
    {
        return $this->select('MX_BankData.*, CF.NamaPemesan NamaPemesan, JP.nama KetJenisProduk, M1.Nama as NamaMaterial1, M2.Nama as NamaMaterial2, M3.Nama as NamaMaterial3, M4.Nama as NamaMaterial4, AD.nama KetJenisAdhesive')
            ->join('CustomerFile CF', 'MX_BankData.Pemesan = CF.NoPemesan', 'left')
            ->join('MX_JenisProduk JP', 'MX_BankData.JenisProduk = JP.id', 'left')
            ->join('MX_Material M1', 'MX_BankData.Material1 = M1.ID', 'left')
            ->join('MX_Material M2', 'MX_BankData.Material2 = M2.ID', 'left')
            ->join('MX_Material M3', 'MX_BankData.Material3 = M3.ID', 'left')
            ->join('MX_Material M4', 'MX_BankData.Material4 = M4.ID', 'left')
            ->join('MX_Adhesive AD', 'MX_BankData.JenisAdhesive = AD.id', 'left')
            ->where('MX_BankData.ID', $id)
            ->get();
    }
}
