<?php

namespace App\Controllers\API;

use App\Models\ClientModel;
use CodeIgniter\RESTful\ResourceController;

class ClientController extends ResourceController
{

    public function __construct() {
        $this->model = $this->setModel(new ClientModel());
        helper('access_rol_helper'); // helper for validate the user's roles
    }

    public function index(){
       // allow roles for this service get -client:admin or user 
        try {
            if(!isValidRol(array('admin','user'),$this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("The Current Rol does Not has access to this resource");
            }
    
            $clients=$this->model->findAll();
            return $this->respond($clients);

        } catch (\Throwable $ex) {
            return $this->failServerError("An error has occurred",$ex);
        }
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

    public function getById($id=null)
    {
        try {
            if(!$id){
                return $this->failValidationErrors('Invalid Id');
            }

            $clientFetched=$this->model->find($id);

            if(!$clientFetched){
                return $this-> failNotFound('Client Not found with id: '.$id);
            }

            return $this->respond($clientFetched);

        } catch (\Throwable $ex) {
            return $this->failServerError("An error has occurred",$ex);
        }
    }

    public function update($id=null)
    {
        try {
            if(!$id){
                return $this->failValidationErrors('Invalid Id');
            }

            $clientFetched=$this->model->find($id);

            if(!$clientFetched){
                return $this-> failNotFound('Client Not found with id: '.$id);
            }

            $clientRequest=$this->request->getJSON();

            if($this->model->update($id,$clientRequest)){
                $clientRequest->id=$id;
                return $this->respondUpdated($clientRequest);
            }
            else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            }

        } catch (\Throwable $ex) {
            return $this->failServerError("An error has occurred",$ex);
        }
    }

    public function deleteById($id=null)
    {
        try {
            if(!$id){
                return $this->failValidationErrors('Invalid Id');
            }

            $clientFetched=$this->model->find($id);

            if(!$clientFetched){
                return $this-> failNotFound('Client Not found with id: '.$id);
            }

            if($this->model->delete($id)){
                return $this->respondDeleted($clientFetched,"Client Deleted Succesfully");
            }
            else{
                return $this->failServerError('A server error has occurred');
            }

        } catch (\Throwable $ex) {
            return $this->failServerError("An error has occurred",$ex);
        }
    }
}