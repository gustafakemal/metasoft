<?php

namespace App\Libraries;

class Authentication
{
    private $user;
    
    public function login($UserID, $password)
    {
        $model = new \App\Models\UsersModel;
        $user = $model->getByUserID($UserID);

        if($user === null) {
            return false;
        }

        if($password !== $UserID) {
            return false;
        }

        // if(!$user->verifyPassword($password)) {
        //     return false;
        // }

        $session = session();
        $session->regenerate();
        $session->set('UserID', $user->UserID);

        return true;
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