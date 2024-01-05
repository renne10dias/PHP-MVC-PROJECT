<?php

namespace app\controller\apiControllers\public;

class User{

    private $httpCode;
    public function getHttpCode(){
        return $this->httpCode;
    }


    public function show($id){

        $this->httpCode = 200;
        echo "Mostrar usuário com ID: $id";
    }
}