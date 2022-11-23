<?php

namespace App\Models;

use CodeIgniter\Model;

class MFKelompokProdukModel extends Model
{
    protected $table = 'MF_KelompokProduk';
    protected $useTimestamps = true;
    protected $createdField = 'added';
    protected $updatedField = 'updated';
    protected $allowedFields = [
        'id_produk', 'id_part', 'utama', 'aktif', 'added', 'added_by', 'updated', 'updated_by'
    ];
    protected $validationRules = [];
    protected $validationMessages = [];

    /**
     * @param $id_produk
     * @return array
     */
    public function getIdsPart($id_produk): array
    {
        $query = $this->select('id_part')
            ->where('id_produk', $id_produk)
            ->get();
        if ($query->getNumRows() > 0) {
            $ids = [];
            foreach ($query->getResult() as $row) {
                $ids[] = $row->id_part;
            }

            return $ids;
        } else {
            return [];
        }
    }

    /**
     * @param $id_part
     * @param $id_product
     * @return bool
     */
    public function checkLinkedProduct($id_part, $id_product): bool
    {
        $query = $this->select('id')
            ->where('id_part', $id_part)
            ->where('id_produk', $id_product)
            ->get()->getNumRows();

        if ($query == 0) {
            return false;
        }

        return true;
    }
}
