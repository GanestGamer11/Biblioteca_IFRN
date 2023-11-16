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

$formulario_base = array(
    "email" => "admin@admin.com",
    "titulo" => "",
    "autor" => "",
    "descricao" => "",
    "editora" => "",
    "genero" => "",
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
            popen("cls","w");
            echo"\n-----Cadastro de Livro-----\n";
            $form = $formulario_base;
            echo "Digite o título do livro:\n";
            $titulo = readline();
            echo "Digite o autor do livro:\n";
            $autor = readline();
            echo "Digite a descrição do livro:\n";
            $descricao = readline();
            echo "Digite a editora do livro:\n";
            $editora = readline();
            echo "Digite o gênero do livro:\n";
            $genero = readline();

            $form['titulo'] = $titulo;
            $form['autor'] = $autor;
            $form['descricao'] = $descricao;
            $form['editora'] = $editora;
            $form['genero'] = $genero;

            $resp = enviar_requisicao("$url_api/livros",
                metodo: "POST",
                corpo: json_encode($form),
                cabecalhos: ['Content-type:application/json']
            );

            if($resp['codigo'] == "201"){
                echo "--LIVRO CADASTRADO COM SUCESSO--\n";
            }else if($resp['codigo'] == "400"){
                echo "--USUARIO PRECISA ESTAR LOGADO--\n";
            }

            break;
        case "3":
            popen("cls","w");
            echo"\n-----Exibir Livro-----\n";
            echo "Digite o id do livro\n";
            $id = intval(readline());
            $resp = enviar_requisicao("$url_api/livros/{$id}");

            if($resp['codigo'] == "20"){
                echo "--LIVRO ENCONTRADO--\n";
            }else if($resp['codigo'] == "502"){
                echo "--O LIVRO NAO EXISTE--\n";
                break;
            }

            $resp_json = json_decode($resp['corpo'], true);

            echo "\n-----".$resp_json['message']."-----\n";
            
            foreach ($resp_json["result"] as $key => $value) {
                echo ucfirst("$key: ").$value."\n";
            }
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