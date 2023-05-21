<?php 
namespace App\Models;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;

class TransactionModel extends Model{

    protected $table='transactions';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['account_id','transaction_type_id','amount','status'];

    protected $useTimestamps=true; // When new register it created or update automatically change th dates in DB.
    protected $createdField='create_at';
    protected $updatedField='update_at';

    protected $validationRules=[ 
        'account_id'=> 'required|integer',
        'transaction_type_id'=> 'required|integer',
        'amount'=> 'required|numeric',
        'status'=> 'permit_empty|integer',

    ];

    protected $skipValidation=false;

    //Custom Query Tables

    public function transactionByClientQuery($clientId=null){

        //Join Table 1)transaction->2)accounts->3)clients : the order Join it's important

        $builder=$this->db->table($this->table);// table transaction
        //$builder->select('*'); // return al fields
        $builder->select('accounts.id AS accountNumber,clients.name ,clients.email,transactions.amount');
        $builder->join('accounts','accounts.id=transactions.account_id');
        $builder->join('clients','clients.id=accounts.client_id');
        $builder->where('clients.id',$clientId);

        $query=$builder->get();
        return $query->getResult();

        //HERE: pending status transaction???

    }



}