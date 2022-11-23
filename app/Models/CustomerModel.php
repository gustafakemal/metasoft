<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'CustomerFile';
    protected $useTimestamps = true;
    protected $createdField = 'CreateDate';
    protected $updatedField = 'LastUpdate';
    protected $allowedFields = ['NoPemesan', 'PemesanInduk', 'InternEkstern', 'NamaPemesan', 'Alamat', 'NoFax', 'NoTelp', 'ContactPerson1', 'ContactPerson2', 'WajibPajak', 'NPWP', 'AlamatPengiriman1', 'AlamatPengiriman2', 'AlamatPenagihan', 'FlagAktif', 'CreateBy', 'CreateDate', 'UpdateBy', 'LastUpdate'];
    protected $validationRules = [
        'NamaPemesan' => 'required',
    ];
    protected $validationMessages = [
        'NamaPemesan' => [
            'required' => 'Field Nama pemesan harus diisi.',
        ],
    ];

    /**
     * @return array
     */
    public function getOpsi(): array
    {
        $query = $this->where('FlagAktif', 'A')
            ->orderBy('NamaPemesan', 'asc')
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return [];
        }
    }

    /**
     * @return array
     */
    public function getCustomers(): array
    {
        return $this->orderBy('NoPemesan', 'desc')
            ->asObject()
            ->findAll();
    }

    /**
     * @param $no_pemesan
     * @return array
     */
    public function getById($no_pemesan): array
    {
        return $this->where('NoPemesan', $no_pemesan)->findAll();
    }

    /**
     * @return int
     */
    public function getMaxNoPemesan(): int
    {
        $query = $this->selectMax('NoPemesan')->get();

        return (int)$query->getResult()[0]->NoPemesan;
    }

    /**
     * @param $NoPemesan
     * @param $data
     * @return bool
     * @throws \ReflectionException
     */
    public function updateById($NoPemesan, $data): bool
    {
        return $this->where('NoPemesan', $NoPemesan)
            ->set($data)
            ->update();
    }

    /**
     * @param $NoPemesan
     * @return bool|\CodeIgniter\Database\BaseResult
     */
    public function deleteById($NoPemesan)
    {
        return $this->where('NoPemesan', $NoPemesan)
            ->delete();
    }

    /**
     * @param $no_pemesan
     * @return null|string
     */
    public function getName($no_pemesan)
    {
        $query = $this->select('NamaPemesan')
            ->where('NoPemesan', $no_pemesan)
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getResult()[0]->NamaPemesan;
        } else {
            return null;
        }
    }
}