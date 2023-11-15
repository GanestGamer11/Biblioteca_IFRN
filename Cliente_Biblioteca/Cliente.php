<?php

require "requisicoes.php";

$url_api = "localhost:8000/api";
$options = array(
    "1" => "Listar livros",
    "2" => "Cadastrar Livro",
    "3" => "Exibir Livro",
    "4" => "Editar Livro",
    "5" => "Deletar Livro",
    "6" => "Sair"                
);
popen("cls","w");
$logado = false;//fazer algo com isso depois
while(true){

    echo "|----------Biblioteca_IFRN----------|\n";
    foreach($options as $key => $value){
        echo $key ."-". $value ."\n";
    }
    $option = readline();
    switch($option){
        case "1":
            $resp = enviar_requisicao("$url_api/livros");
            $resp_json = json_decode($resp['corpo'], true);

            echo "\n-----".$resp_json['message']."-----\n";
            foreach ($resp_json["result"] as $item) {
                echo $item["id"]." - ".$item["titulo"] . "\n";
            }
            echo"\n";
            break;
        case "2":
            break;
        case "3":
            break;
        case "4":
            break;
        case "5":
            break;
        case "6":   
            return false;
            break;
    }
}


?>