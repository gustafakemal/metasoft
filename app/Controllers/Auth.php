<?php

namespace App\Controllers;
use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new UsersModel();
	}

    function decrypt($data, $key) {
        return openssl_decrypt(base64_decode($data), 'aes-128-ecb', $key, OPENSSL_PKCS1_PADDING);
    }

    /**
     * @return string
     */
    public function login(): string
    {

        return view('login');
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function verify(): ResponseInterface
    {
//        $username = $this->request->getPost('username');
//        $password = $this->request->getPost('password');

        $data = $this->request->getPost();

        $auth = service('auth');
        $result = $auth->login($data['username'], $data['password']);

        if($result['isValid']) {
            $response = [
                'success' => true,
                'redirect' => base_url(),
                'msg' => ''
            ];
        } else {
            $response = [
                'success' => false,
                'redirect' => '',
                'msg' => $result['msg']
            ];
        }

        return $this->response->setJSON($response);

//        if($result['isValid']) {
//            return redirect()->to('/');
//        } else {
//            return redirect()->back()
//                            ->with('error', $result['msg']);
//        }
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