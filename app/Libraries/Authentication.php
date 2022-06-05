<?php

namespace App\Libraries;

class Authentication
{
    public function login($username, $password)
    {
        if($username != 'dummy' && $password != 'dummy') {
            return false;
        }
        // $model = new \App\Models\UsersModel;
        // $user = $model->findByEmail($email);

        // if($user === null) {
        //     return false;
        // }

        // if(!$user->verifyPassword($password)) {
        //     return false;
        // }

        $session = session();
        $session->regenerate();
        // $session->set('user_id', $user->id);
        $session->set('user_id', 'dummy');

        return true;
    }

    public function logout() {
        session()->destroy();
    }

    public function isLoggedIn() {
        return session()->has('user_id');
    }

    public function getCurrentUser() {
        // if(!$this->isLoggedIn()) {
        //     return null;
        // }

        // if($this->user === null) {
        //     $model = new \App\Models\UsersModel;

        //     $this->user = $model->find(session()->get('user_id'));
        // }

        // return $this->user;
    }
}