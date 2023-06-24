<?php 
namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model{

    protected $table='roles';
    protected $primaryKey='id';
    protected $returnType='array';
    protected $allowedFields=['name'];

    protected $useTimestamps=true; // When new register it created or update automatically change th dates in DB.
    protected $createdField='create_at';
    protected $updatedField='update_at';

    protected $validationRules=[ 
        'name'=> 'required|alpha_space|min_length[3]|max_length[10]'
    ];

    protected $skipValidation=false;
}