<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class MFSisiProdukModel extends Model
{
    protected $table = 'MF_SisiProduk';
    protected $useTimestamps = true;
    protected $createdField  = 'added';
    protected $updatedField  = 'updated';
    protected $allowedFields = [
        'id', 'id_part', 'sisi', 'frontside', 'backside', 'special_req', 'aktif', 'added', 'added_by', 'updated', 'updated_by'
    ];
    protected $validationRules = [
        'id' => 'required',
        'id_part' => 'required',
        'sisi' => 'required',
        'frontside' => 'required',
        'backside' => 'required'
    ];
    protected $validationMessages = [];

    public function getAllSisi()
    {
        return $this->orderBy('id', 'desc')
                    ->get();
    }

    public function getAllSisiByPart($id_part)
    {
        return $this->where('id_part', $id_part)
                    ->get();
    }

    public function getSisiById($id)
    {
        return $this->where('id', $id)
            ->get();
    }
}
