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
        $query = $this->asObject()->where('UserID', $UserID);

        if($query->get()->getNumRows() > 0) {
            return $query->first();
        }

        return null;
    }
}