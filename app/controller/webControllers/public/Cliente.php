<?php

namespace app\controller\webControllers\public;
header('Content-Type: application/json');

class Cliente{

    private $httpCode;
    public function getHttpCode(){
        return $this->httpCode;
    }


    public function home(){
        $this->httpCode = 200;

        // Constrói o caminho do arquivo usando __DIR__
        $htmlFilePath = __DIR__ . '/../../../../public/html/index.html';


        // Verifica se o arquivo existe antes de tentar lê-lo
        if (file_exists($htmlFilePath)) {
            // Lê o conteúdo do arquivo HTML
            $htmlContent = file_get_contents($htmlFilePath);

            // Define o tipo de conteúdo como HTML
            header('Content-Type: text/html');

            // Envia o conteúdo do HTML como resposta
            echo $htmlContent;
        } else {
            // Se o arquivo não existir, envie uma resposta de erro
            $this->httpCode = 404;
            echo json_encode(["error" => "Arquivo HTML não encontrado"]);
        }
    }



    public function details(){
        $this->httpCode = 200;

        // Constrói o caminho do arquivo usando __DIR__
        $htmlFilePath = __DIR__ . '/../../../../public/html/details.html';


        // Verifica se o arquivo existe antes de tentar lê-lo
        if (file_exists($htmlFilePath)) {
            // Lê o conteúdo do arquivo HTML
            $htmlContent = file_get_contents($htmlFilePath);

            // Define o tipo de conteúdo como HTML
            header('Content-Type: text/html');

            // Envia o conteúdo do HTML como resposta
            echo $htmlContent;
        } else {
            // Se o arquivo não existir, envie uma resposta de erro
            $this->httpCode = 404;
            echo json_encode(["error" => "Arquivo HTML não encontrado"]);
        }
    }



}


