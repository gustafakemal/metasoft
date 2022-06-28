<?php

namespace App\Controllers;
use App\Models\UsersModel;

class Auth extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new UsersModel();
	}

    public function login()
    {
        return view('login');
    }

    public function verify()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        
        

        $auth = service('auth');
        $result=$auth->login($username, $password);
        if($result['isValid']) {
            return redirect()->to('/');
        } else {
            return redirect()->back()
                            ->with('error', $result['msg']);
        }
    }

    public function logout()
    {
        service('auth')->logout();

        return redirect()->to('login');
    }
}