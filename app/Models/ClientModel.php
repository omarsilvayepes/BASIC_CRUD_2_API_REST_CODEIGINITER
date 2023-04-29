<?php 
namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model{

    protected $table='clients';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['name','lastName','telephone','email'];

    protected $useTimestamps=true; // When new register it created or update automatically change th dates in DB.
    protected $createdField='create_at';
    protected $updatedField='update_at';

    protected $validationRules=[ 
        'name'=> 'required|alpha_space|min_length[3]|max_length[75]',
        'lastName'=> 'required|alpha_space|min_length[3]|max_length[75]',
        'telephone'=> 'required|numeric|min_length[8]|max_length[8]',
        'email'=> 'permit_empty|valid_email|min_length[3]|max_length[85]'
    ];

    protected $validationMessages=[ 
        'email' =>[
            'valid_email'=> 'Dear user,you should type an valid email!...'
        ]
    ];

    protected $skipValidation=false;
}