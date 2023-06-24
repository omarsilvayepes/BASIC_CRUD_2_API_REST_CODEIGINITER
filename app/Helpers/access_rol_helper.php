<?php

use App\Models\RolModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

 function isValidRol($roles,$authHeader){

    if(!is_array($roles)){
        return false;
    }

    $key=Services::getSecretKey();
    $array=explode(' ',$authHeader);
    $jwt=$array[1];
    $jwt=JWT::decode($jwt,new Key($key, 'HS256'));

    $rolModel=new RolModel();
    $rolFetched=$rolModel->find($jwt->data->rol_id);

    if(!$rolFetched){
        return false;
    }

    if(!in_array($rolFetched['name'],$roles)) {
        return false;
    }
    return true;
 }

?>