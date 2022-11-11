<?php

namespace App\Controllers;
use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new UsersModel();
	}

    /**
     * @return string
     */
    public function login(): string
    {
        return view('login');
    }

    /**
     * @return RedirectResponse
     */
    public function verify(): RedirectResponse
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

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        service('auth')->logout();

        return redirect()->to('login');
    }
}