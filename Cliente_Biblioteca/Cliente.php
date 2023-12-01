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

// Aqui, temos o email de um suposto usuário logado sendo passado por padrão no corpo do formulário
$formulario_base = array(
    "email" => "admin@admin.com",
    "titulo" => "",
    "autor" => "",
    "descricao" => "",
    "editora" => "",
    "genero" => "",
    "Authorization:" => "Bearer {token}"
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
            $dados = [];
            foreach($form as $key => $value){
                if($key == "email"){
                    continue;
                }
                echo ucfirst($key).": ";
                $dados[$key] = readline();

            }
            foreach($dados as $key => $value){
                $form[$key] = $value;
            }

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

            if($resp['codigo'] == "200"){
                echo "--LIVRO ENCONTRADO--\n";
            }else if($resp['codigo'] == "502"){
                echo "--O LIVRO NAO EXISTE--\n";
                break;
            }
            $resp_json = json_decode($resp['corpo'], true);

            echo "\n-----".$resp_json['message']."-----\n";
            
            foreach ($resp_json["result"] as $key => $value) {
                if($key == "remember_token" || $key == "created_at" || $key == "updated_at"){
                    continue;
                }
                echo ucfirst("$key: ").$value."\n";
            }
            echo "\n";
            break;
        case "4":
            popen("cls","w");
            echo"\n-----Editar Livro-----\n";
            echo "Digite o id do livro\n";
            $id = intval(readline());
            $resp = enviar_requisicao("$url_api/livros/{$id}");

            if($resp['codigo'] == "200"){
                $resp_json = json_decode($resp['corpo'], true);
                $form = $formulario_base;

                echo "\n----Livro----\n";
                echo "**Mantenha o campo vazio caso não deseje editar**\n";
                $edicoes = [];
                foreach($resp_json['result'] as $key => $value){
                    if($key == "id" || $key == "remember_token" || $key == "created_at" || $key == "updated_at"){
                        continue;
                    }
                    echo ucfirst($key) . ": " . $value . "\n";
                    $aux = readline();

                    if ($aux !== '') {
                        $edicoes[$key] = $aux;
                    }else{
                        $form[$key] = $value;
                    }
                }
                foreach ($edicoes as $key => $value) {
                    $form[$key] = $value;
                }
                $resp = enviar_requisicao("$url_api/livros/{$id}",
                    metodo: "PUT",
                    corpo: json_encode($form),
                    cabecalhos: ['Content-type:application/json']
                );
                echo "-----LIVRO EDITADO COM SUCESSO----\n";
                break;
            }else if($resp['codigo'] == "502"){
                echo "--LIVRO NÃO ENCONTRADO--\n";
                break;
            }

            break;
        case "5":
            popen("cls","w");
            echo"\n-----Excluir Livro-----\n";
            echo "Digite o id do livro\n";
            $id = intval(readline());
            $resp = enviar_requisicao("$url_api/livros/{$id}", metodo: "HEAD");

            if($resp['codigo'] == "200"){
                $resp = enviar_requisicao("$url_api/livros/{$id}", metodo: "DELETE");
                echo "--LIVRO DELETADO--\n";
            }else if($resp['codigo'] == "502"){
                echo "--LIVRO NÃO ENCONTRADO--\n";
            }
            break;
        case "6":   
            return false;
            break;
        default:
            echo "--Número inválido--\n";
            break;
    }
}
?>