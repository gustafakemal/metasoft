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

		if(($query->getNumRows()>0)){
            $UserName= $query->getResult()[0]->Nama;
            // $validData = $model->isValidPass($UserID,$password);
            
            //     if(($validData[0]->Valid)){
                    $isValid=true;
                    //return "Pass OK";
                // }else{
                //     $msg = "Password tidak sesuai";
                // }
            
           
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

        $db = \Config\Database::connect();
        $niks = $db->query("select * from MF_ModulMapPriv where nik='" . $UserID . "'");
        $modul_ids = array_map(function ($item) {
            return $item->modul_id;
        }, $niks->getResult());
        $modul_ids = implode(', ', $modul_ids);
        $query = $db->query("select a.id, a.display, a.parent, a.menu_icon, a.route, a.dependant_routes, a.site, a.active, b.method, b.path, b.src from MF_ModulDef a left join MF_ModulRoutes b on a.route = b.name where a.id in (". $modul_ids . ")");

        $session = session();
        //$session->regenerate();
        $session->set('UserID', $UserID);
        $session->set('UserName', $UserName);
        $session->set('priv', $query->getResult());

        return [
            'isValid' => $isValid,
            'msg' => $msg
        ];;
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