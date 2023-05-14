<?php

namespace App\Controllers\API;

use App\Models\TransactionModel;
use App\Models\AccountModel;
use App\Models\ClientModel;
use CodeIgniter\RESTful\ResourceController;

class TransactionController extends ResourceController
{

    private $accountModel;
    private $clientModel;

    public function __construct() {
        $this->model = $this->setModel(new TransactionModel());
        $this->accountModel=new AccountModel();
        $this->clientModel=new ClientModel();
    }

    public function index(){
        $transactions=$this->model->findAll();
        return $this->respond($transactions);
    }

    public function create()
    {
        try {
            $transaction=$this->request->getJSON();
            if($this->model->insert($transaction)){
                $transaction->id=$this->model->insertID();

                //Update Account

                $transaction->result=$this->updateAmountAccount($transaction->transaction_type_id,$transaction->amount,$transaction->account_id);

                return $this->respondCreated($transaction);
            }
            else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Throwable $ex) {
            return $this->failServerError("An error has occurred",$ex);
        }
    }

    public function updateAmountAccount(int $typeTrasactionId,float $amount,int $accountId)
    {
        $accountFetched=$this->accountModel->find($accountId);

        switch ($typeTrasactionId) {
            case 1:
                $accountFetched['funds']+=$amount;
                break;
            
            case 2:
                $accountFetched['funds']-=$amount;
                break;
        }

        if($this->accountModel->update($accountId,$accountFetched)){
            return array('Success Transaction' => true,'New Amount' => $accountFetched['funds']);
        }

        return array('Success Transaction' => false,'New Amount' => $accountFetched['funds']);


    }

    public function getTransactionByClientId($id=null){

        try {
            if(!$id){
                return $this->failValidationErrors('Invalid Id');
            }

            $clientFetched=$this->clientModel->find($id);

            if(!$clientFetched){
                return $this-> failNotFound('Client Not found with id: '.$id);
            }

            $transactionQueryResponse=$this->model->transactionByClientQuery($id);

            return $this->respond($transactionQueryResponse);


        } catch (\Throwable $ex) {
            return $this->failServerError("An Sever error has occurred",$ex);
        }

    }

}