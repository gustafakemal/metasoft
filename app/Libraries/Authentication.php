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
		if($query->getNumRows()>0){
            $UserName= $query->getResult()[0]->Nama;
            $validData = $model->isValidPass($UserID,$password);
            if($validData[0]->Valid)
                $isValid=true;
                //return "Pass OK";
            else
                $msg = "Password tidak sesuai";
            
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

        $session = session();
        $session->regenerate();
        $session->set('UserID', $UserID);
        $session->set('UserName', $UserName);

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