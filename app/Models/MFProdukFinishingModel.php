<?php

namespace App\Models;

use CodeIgniter\Database\ResultInterface;
use CodeIgniter\Model;

class MFProdukFinishingModel extends Model
{
    protected $table = 'MF_ProdukFinishing';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_sisi', 'proses'];

    /**
     * @param $id_sisi
     * @return \CodeIgniter\Database\ResultInterface|false|string
     */
    public function getTintaBySisi($id_sisi): ResultInterface
    {
        $query = $this->select('*')
            ->join('MF_ProsesFinishing', 'MF_ProdukFinishing.proses = MF_ProsesFinishing.id')
            ->where('MF_ProdukFinishing.id_sisi', $id_sisi)
            ->get();

        return $query;
    }

    /**
     * @param $id_sisi
     * @return bool|\CodeIgniter\Database\BaseResult
     */
    public function deleteAllSisi($id_sisi)
    {
        return $this->where('id_sisi', $id_sisi)
            ->delete();
    }

    /**
     * @param $prod_id
     * @return array
     */
    public function getByProdID($prod_id): array
    {
        $query = $this->select('MF_ProdukFinishing.proses as id, MF_ProsesFinishing.proses')
            ->join('MF_ProsesFinishing', 'MF_ProdukFinishing.proses = MF_ProsesFinishing.id')
            ->where('MF_ProdukFinishing.id_produk', $prod_id)
            ->get();

        if ($query->getNumRows() > 0) {
            return $query->getResult();
        }

        return [];
    }

    /**
     * @param $data
     * @return bool|int
     * @throws \ReflectionException
     */
    public function reInsert($data)
    {
        $ids = array_map(function ($item) {
            return $item['id_produk'];
        }, $data);
        $this->whereIn('id_produk', $ids)
            ->delete();

        return $this->insertBatch($data);
    }

    /**
     * @param $prod_id
     * @return bool|\CodeIgniter\Database\BaseResult
     */
    public function deleteByProdID($prod_id)
    {
        return $this->where('id_produk', $prod_id)
            ->delete();
    }
}
