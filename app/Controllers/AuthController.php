<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function __construct() {
        helper('secure_password');
    }

    //HERE: 1)create Register User method using  hash_password function of  the helper
    //2)delete user DB
    //3 test register and the longin mehtod 
    //4)continue in minute 14:30 video 10, remaining [1:30,2:38]min ->composer for JWT

    public function login()
    {
        try 
        {
            $userModel=new UserModel();

            $username=$this->request->getPost('username'); // get data from :body :form-data
            $password=$this->request->getPost('password');

            $FetchedUser=$userModel->where('username',$username)->first();

            if(!$FetchedUser){
                return $this->failNotFound('User Not Found');
            }

            if(!verifyPassword($password,$FetchedUser['password'])){
                return $this->failValidationErrors('Password Wrong');
            }

            return $this->respond('User Found Succesfully');

        } catch (\Throwable $ex) {
            return $this->failServerError("An Server Error has occurred",$ex);
        }
    }
}