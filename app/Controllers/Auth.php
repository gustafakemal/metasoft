<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function verify()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $auth = service('auth');

        if($auth->login($username, $password)) {
            return redirect()->to('/');
        } else {
            return redirect()->back()
                            ->with('error', 'Username atau password salah.');
        }
    }

    public function logout()
    {
        service('auth')->logout();

        return redirect()->to('login');
    }
}