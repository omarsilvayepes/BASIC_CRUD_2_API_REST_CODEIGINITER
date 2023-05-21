<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table='users';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['name','username','password','rol_id'];

    protected $useTimestamps=true; // When new register it created or update automatically change th dates in DB.
    protected $createdField='create_at';
    protected $updatedField='update_at';

    protected $validationRules=[ 
        'name'=> 'required|alpha_space|min_length[3]|max_length[65]',
        'username'=> 'required|alpha_space|min_length[5]|max_length[10]',
        'password'=> 'required|alpha_space|min_length[8]|max_length[65]',
        'rol_id'=> 'required|integer'
    ];

    protected $skipValidation=false;
}