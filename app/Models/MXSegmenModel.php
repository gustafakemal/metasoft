<?php
namespace App\Models;

class MXSegmenModel extends \CodeIgniter\Model
{
    protected $table = 'MX_Segmen';
    protected $allowedFields = ['ID','Nama','Aktif'];
    protected $createdField = 'added';
    protected $updatedField = 'updated';

    public function getAll()
    {
        $query = $this->db->query("SELECT * from MX_Segmen order by Nama");
        $result_array = $query->getResultArray();
        return $result_array;
    }

    public function getId($id)
    {
        $query = $this->db->query("SELECT * from MX_Segmen where ID='".$id."'");
        $result_array = $query->getResultArray();
        return $result_array;
    }

    // public function getList()
    // {
    //     $query = $this->db->query("SELECT * from MX_Segmen where Aktif='Y' order by Nama");
    //     $result_array = $query->getResultArray();
    //     return $result_array;
    // }    49.986.900


    // public function getUpdate($id,$set)
    // {
    //     $query = $this->db->query("update MX_Segmen set Aktif='".$set."' where ID='".$id."'");
    //     return $query;
    // }
}

