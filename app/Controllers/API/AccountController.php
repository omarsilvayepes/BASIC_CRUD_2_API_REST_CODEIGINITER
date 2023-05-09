<?php

namespace App\Controllers\API;

use App\Models\AccountModel;
use CodeIgniter\RESTful\ResourceController;

class AccountController extends ResourceController
{

    public function __construct() {
        $this->model = $this->setModel(new AccountModel());
    }

    public function index(){
        $accounts=$this->model->findAll();
        return $this->respond($accounts);
    }

    public function create()
    {
        try {
            $account=$this->request->getJSON();
            if($this->model->insert($account)){
                $account->id=$this->model->insertID();
                return $this->respondCreated($account);
            }
            else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Throwable $ex) {
            return $this->failServerError("An error has occurred",$ex);
        }
    }

}