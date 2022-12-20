<?php

namespace App\Models;

use CodeIgniter\Database\ResultInterface;
use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'UserPass';
    protected $allowedFields = ['UserID', 'UserPass', 'Nama', 'NIK', 'FlagAktif', 'Email'];
    protected $validationRules = [];
    protected $validationMessages = [];

    public function getAll()
    {
        return $this->asObject()->findAll();
    }

    public function getUsersAndAccess($mod_id)
    {
        return $this->select('UserPass.*, MF_ModulAccess.nik, MF_ModulAccess.modul, MF_ModulAccess.access')
                        ->join('MF_ModulAccess', 'MF_ModulAccess.nik = UserPass.UserID', 'inner')
                        ->get();
    }

    /**
     * @param $UserID
     * @return \CodeIgniter\Database\ResultInterface|false|string
     */
    public function getByUserID($UserID): ResultInterface
    {
        $query = $this->where('UserID', $UserID)
            ->where('FlagAktif', 'A')
            ->get();
        return $query;
    }

    /**
     * @param $id
     * @return array
     */
    public function getNamaById($id): array
    {
        return $this->where('UserID', $id)->findAll();
    }

    /**
     * @param $userid
     * @param $tekspass
     * @return array
     */
    public function isValidPass($userid, $tekspass): array
    {
        $query = $this->db->query("select CASE WHEN (UserPass = dbo.f_set_userpass('$tekspass')) THEN 1 ELSE 0 END Valid from UserPass where UserID = '$userid'");
        return $query->getResult();
    }

}