<?php

namespace App\Libraries;

class Authentication
{
    private $user;

    public function login($UserID, $password)
    {


        $model = new \App\Models\UsersModel;
        $user = $model->getByUserID($UserID);
        $UserName = '';
        $isValid = false;
        $msg="";

        $query = $model->getByUserID($UserID);

        if(($query->getNumRows()>0)) {
            $UserName= $query->getResult()[0]->Nama;
            $validData = (getenv('forceSecureAuth') !== false) ? (new \App\Libraries\Common())->isExist() : $model->isValidPass($UserID,$password);
            //$validData = $model->isValidPass($UserID,$password);

            if(($validData[0]->Valid)){
                $isValid = true;
                //return "Pass OK";

                /**
                 * Priviledges
                 */
                $db = \Config\Database::connect();
                $priv = $db->query("select a.id as modul_id, a.nama_modul, a.route, a.icon, a.group_menu, b.access, b.nik from MF_Modul a right join MF_ModulAccess b on a.id = b.modul where b.nik='" . $UserID . "'");

                $parsePriv = [];
                if($priv->getNumRows() > 0) {
                    foreach ($priv->getResult() as $row) {
                        if( in_array($row->route, $this->parseAvailableRoutes()) ) {
                            $parsePriv[] = $row;
                        }
                    }
                }

                $session = session();
                //$session->regenerate();
                $session->set('UserID', $UserID);
                $session->set('UserName', $UserName);
                $session->set('priv', $parsePriv);

            } else {
                $msg = "Password tidak sesuai";
            }




        }else {
            $msg =  "User tidak terdaftar";
        }



        if(!($isValid)) {
            return [
                'isValid' => $isValid,
                'msg' => $msg
            ];
        }

        // if(!$user->verifyPassword($password)) {
        //     return false;
        // }

        return [
            'isValid' => $isValid,
            'msg' => $msg
        ];;
    }

    public function parseAvailableRoutes()
    {
        $ad = (new \App\Libraries\AccessDefinition())->availableRoutes();
        $arrs = [];
        foreach ($ad as $key => $ck) {
            $arrs[] = $key;
        }
        return $arrs;
    }

    public function logout() {
        session()->destroy();
    }

    public function isLoggedIn() {
        return session()->has('UserID');
    }

    public function getCurrentUser() {
        if(!$this->isLoggedIn()) {
            return null;
        }

        if($this->user === null) {
            $model = new \App\Models\UsersModel;

            $this->user = $model->asObject()->where('UserID', session()->get('UserID'))->first();
        }

        return $this->user;
    }
}