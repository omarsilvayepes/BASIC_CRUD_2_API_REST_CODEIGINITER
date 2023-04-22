<?php

namespace App\Controllers\API;

use App\Models\ClientModel;
use CodeIgniter\RESTful\ResourceController;

class ClientController extends ResourceController
{

    public function __construct() {
        $this->model = $this->setModel(new ClientModel());
    }

    public function index(){
        $clients=$this->model->findAll();
        return $this->respond($clients);
    }

    public function create()
    {
        try {
            $client=$this->request->getJSON();
            if($this->model->insert($client)){
                $client->id=$this->model->insertID();
                return $this->respondCreated($client);
            }
            else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Throwable $ex) {
            return $this->failServerError("An error has occurred",$ex);
        }
    }
}