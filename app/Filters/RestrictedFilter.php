<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RestrictedFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');
        $response->setStatusCode(403);

        if( $request->isAJAX() ) {
            $response->setJSON(['success' => false, 'msg' => 'Anda tidak memiliki akses']);
        } else {
            $response->setBody(view('Common/restricted'));
        }

        return $response;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }

}