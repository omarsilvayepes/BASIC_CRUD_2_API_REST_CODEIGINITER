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
}