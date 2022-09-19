<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'CustomerFile';
    protected $useTimestamps = true;
    protected $createdField  = 'CreateDate';
    protected $updatedField  = 'LastUpdate';
    protected $allowedFields = ['NoPemesan', 'PemesanInduk', 'InternEkstern', 'NamaPemesan', 'Alamat', 'NoFax', 'NoTelp', 'ContactPerson1', 'ContactPerson2', 'WajibPajak', 'NPWP', 'AlamatPengiriman1', 'AlamatPengiriman2', 'AlamatPenagihan', 'FlagAktif', 'CreateBy', 'CreateDate', 'UpdateBy', 'LastUpdate'];
    protected $validationRules = [
        'NamaPemesan' => 'required',
    ];
    protected $validationMessages = [
        'NamaPemesan'        => [
            'required' => 'Field Nama pemesan harus diisi.',
        ],
    ];
    public function getOpsi()
    {
        $query = $this->where('FlagAktif', 'A')
                    ->orderBy('NamaPemesan', 'asc')
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }
    public function getCustomers()
    {
        return $this->orderBy('NoPemesan', 'desc')
                    ->asObject()
                    ->findAll();
    }

    public function getById($no_pemesan)
    {
        return $this->where('NoPemesan', $no_pemesan)->findAll();
    }

    public function getMaxNoPemesan()
    {
        $query = $this->selectMax('NoPemesan')->get();

        return (int)$query->getResult()[0]->NoPemesan;
    }

    public function updateById($NoPemesan, $data)
    {
        return $this->where('NoPemesan', $NoPemesan)
                    ->set($data)
                    ->update();
    }

    public function deleteById($NoPemesan)
    {
        return $this->where('NoPemesan', $NoPemesan)
                    ->delete();
    }

    public function getName($no_pemesan)
    {
        $query = $this->select('NamaPemesan')
                    ->where('NoPemesan', $no_pemesan)
                    ->get();
        if($query->getNumRows() > 0) {
            return $query->getResult()[0]->NamaPemesan;
        } else {
            return null;
        }
    }
}