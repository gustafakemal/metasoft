<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'UserPass';
    protected $allowedFields = ['UserID', 'UserPass', 'Nama', 'NIK', 'FlagAktif', 'Email'];
    protected $validationRules = [];
    protected $validationMessages = [];

    public function getByUserID($UserID)
    {
        $query = $this->where('UserID', $UserID)
                    ->where('FlagAktif', 'A')
                    ->get();
        return $query;
        // if($query->countAllResults()>0)
        // return   $this->where('UserID', $UserID)->get();
        //   //return   $this->where('UserID', $UserID)->findAll();
        // return null;
    }

    public function getNamaById($id)
    {
        
        return $this->where('UserID', $id)->findAll();
    }

    public function isValidPass($userid, $tekspass){
        $query = $this->db->query("select CASE WHEN (UserPass = dbo.f_set_userpass('$tekspass')) THEN 1 ELSE 0 END Valid from UserPass where UserID = '$userid'");
        return $query->getResult();
    }

}