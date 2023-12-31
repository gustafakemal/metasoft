<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Database\ResultInterface;
use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class MFSisiProdukModel extends Model
{
    protected $table = 'MF_SisiProduk';
    protected $useTimestamps = true;
    protected $createdField = 'added';
    protected $updatedField = 'updated';
    protected $allowedFields = [
        'id_part', 'sisi', 'frontside', 'backside', 'special_req', 'aktif', 'added', 'added_by', 'updated', 'updated_by'
    ];
    protected $validationRules = [
        'id_part' => 'required',
        'sisi' => 'required',
        'frontside' => 'required',
        'backside' => 'required'
    ];
    protected $validationMessages = [];

    /**
     * @return \CodeIgniter\Database\ResultInterface|false|string
     */
    public function getAllSisi(): ResultInterface
    {
        return $this->select('MF_SisiProduk.id, MF_SisiProduk.id_part, MF_SisiProduk.sisi, MF_SisiProduk.frontside, MF_SisiProduk.backside, MF_SisiProduk.special_req, MF_SisiProduk.aktif, MF_SisiProduk.added, MF_SisiProduk.added_by, MF_SisiProduk.updated, MF_SisiProduk.updated_by, MF_PartProduk.fgd, MF_PartProduk.revisi')
            ->join('MF_PartProduk', 'MF_SisiProduk.id_part = MF_PartProduk.id', 'left')
            ->orderBy('MF_SisiProduk.id', 'desc')
            ->get();
    }

    /**
     * @param $id_part
     * @return \CodeIgniter\Database\ResultInterface|false|string
     */
    public function getAllSisiByPart($id_part): ResultInterface
    {
        return $this->where('id_part', $id_part)
            ->where('aktif', 'Y')
            ->get();
    }

    /**
     * @param $id_part
     * @return \CodeIgniter\Database\ResultInterface|false|string
     */
    public function getColorsAndProcess($id_part): ResultInterface
    {
        return $this->select('MF_SisiProduk.id, MF_SisiProduk.id_part, MF_ProdukWarna.posisi, MF_ProdukWarna.tinta, MF_ProdukFinishing.proses as proses_finishing')
            ->join('MF_ProdukWarna', 'MF_SisiProduk.id = MF_ProdukWarna.id_sisi', 'left')
            ->join('MF_ProdukFinishing', 'MF_SisiProduk.id = MF_ProdukFinishing.id_sisi', 'left')
            ->where('MF_SisiProduk.id_part', $id_part)
            ->get();
    }

    /**
     * @param $id
     * @return \CodeIgniter\Database\ResultInterface|false|string
     */
    public function getSisiById($id): ResultInterface
    {
        return $this->where('id', $id)
            ->get();
    }

    /**
     * @param $id_part
     * @return int
     */
    public function lastNomorSisi($id_part): int
    {
        $query = $this->selectMax('sisi')
            ->where('id_part', $id_part)
            ->where('aktif', 'Y')
            ->get();

        if ($query->getNumRows() > 0) {
            return (int)$query->getResult()[0]->sisi;
        } else {
            return 0;
        }
    }
}
