<?php 

namespace  App\Models\CustomRulesValidation;

use App\Models\ClientModel;

class MyCustomRules{

    public function isValidClient(int $id):bool
    {
       $model=new ClientModel();
       $client=$model->find($id);

       return $client==null?false:true;
    }

    public function isAllowClient(int $id):bool
    {
       return $id > 1 ? false:true;
    }
}

?>