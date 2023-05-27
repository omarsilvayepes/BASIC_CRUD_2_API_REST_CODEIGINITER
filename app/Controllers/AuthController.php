<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    use ResponseTrait;
    private $userModel;

    public function __construct() {
        helper('secure_password');
        $this->userModel=new UserModel();
    }


    public function Register(){
        try {
            $userRequest=$this->request->getJSON();
            $username=$userRequest->username;
            $password=$userRequest->password;

            $FetchedUser=$this->userModel->where('username',$username)->first();

            if($FetchedUser){
                return $this->failResourceExists('User it is already registered');
            }

            $userRequest->password=hashPassword($password);

            if($this->userModel->insert($userRequest)){
                $userRequest->id=$this->userModel->insertID();
                return $this->respondCreated($userRequest);
            }

            return $this->failValidationErrors($this->userModel->validation->listErrors());

        } catch (\Throwable $ex) {
            return $this->failServerError("An Server Error has occurred",$ex);
        }
    }

    public function Login()
    {
        try 
        {

            $username=$this->request->getPost('username'); // get data from :body :form-data
            $password=$this->request->getPost('password');

            $FetchedUser=$this->userModel->where('username',$username)->first();

            if(!$FetchedUser){
                return $this->failNotFound('User Not Found');
            }

            if(!verifyPassword($password,$FetchedUser['password'])){
                return $this->failValidationErrors('Password Wrong');
            }

            $jwt=$this->generateJWT();
            return $this->respond(['TOKEN'=>$jwt],201);

        } catch (\Throwable $ex) {
            return $this->failServerError("An Server Error has occurred",$ex);
        }
    }

    protected function generateJWT()
    {
        $key=Services::getSecretKey();
        $time=time();
        $payload=[
            'aud'=> base_url(),
            'iat'=> $time,
            'exp'=> $time +60 // expire time
        ];

        $jwt=JWT::encode($payload,$key,'HS256');
        return $jwt;
    }
}