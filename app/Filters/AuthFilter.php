<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface{

    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null){

        // execute before controller

        try {
            $key=Services::getSecretKey();
            $authHeader=$request->getServer('HTTP_AUTHORIZATION');

            if($authHeader==null){
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,'JWT it is required');
            }

            $array=explode(' ',$authHeader);
            $jwt=$array[1];

            JWT::decode($jwt,new Key($key, 'HS256'));

        } catch (ExpiredException $ex) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,' Token JWT  expired',$ex);
        }  
        catch (\Exception $ex) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,'An Server Error has occurred',$ex);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
        // execute after controller
    }

}

?>