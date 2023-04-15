<?php 
namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model{

    protected $table='clients';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['name','lastName','telephone','email'];

    protected $useTimestamps=true; // pending validate ??
    protected $createdField='create_at';
    protected $updatedField='update_at';

    protected $validationRules=[ // pending validate ??
        'name'=> 'required|alpha_space|min_length[3]|max_lenght[75]',
        'lastName'=> 'required|alpha_space|min_length[3]|max_lenght[75]',
        'telephone'=> 'required|numeric|min_length[8]|max_lenght[8]',
        'email'=> 'permit_empty|valid_email|min_length[3]|max_lenght[85]'
    ];

    protected $validationMessages=[ // pending validate ??
        'email' =>[
            'valid_email'=> 'Dear user,you should type an valid email!...'
        ]
    ];

    protected $skipValidation=false;
}