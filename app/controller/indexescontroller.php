<?php

namespace app\controller;

class IndexesController
{

    public function test($data = NULL)
    {
        #return "Ola UserId: " .  $data['userId'];

        #$json = json_encode(['nome' => 'diogo','user_id' => '78']);

        $json = json_encode(['nome' => 'diogo','user_id' => $data['user_id'], 'username'=>$data['username']]);

        return $json;
    }

}


?>