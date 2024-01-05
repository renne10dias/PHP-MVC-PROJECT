<?php

namespace app\controller\apiControllers\public;

class Comment{

    private $httpCode;
    public function getHttpCode(){
        return $this->httpCode;
    }


    public function show($postId, $commentId){
        $this->httpCode = 200;
        echo "Mostrar comentário do post $postId com ID: $commentId";
    }
}
