<?php 
namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model{

    protected $table='accounts';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['currency','funds','client_id'];

    protected $useTimestamps=true; // When new register it created or update automatically change th dates in DB.
    protected $createdField='create_at';
    protected $updatedField='update_at';

    protected $validationRules=[ 
        'currency'=> 'required|alpha_space|min_length[3]|max_length[3]',
        'funds'=> 'required|numeric',
        'client_id'=> 'required|integer|isValidClient|isAllowClient'
    ];

    protected $validationMessages=[ 
        'client_id' =>[
            'isValidClient'=> 'Dear user,you should type an Valid Client!...',
            'isAllowClient'=> 'Dear user,you should type an Allow Client!...'
        ]
    ];

    protected $skipValidation=false;
}