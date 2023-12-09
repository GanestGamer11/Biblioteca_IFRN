<?php
require "cliente_back.php";
require 'vendor/autoload.php';
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

$options = array(
    "1" => "Logar",
    "2" => "Listar livros",
    "3" => "Cadastrar Livro #",
    "4" => "Exibir Livro",
    "5" => "Editar Livro #",
    "6" => "Deletar Livro #",
    "7" => "Sair"                
);

$formulario_base = array(
    "titulo" => "",
    "autor" => "",
    "descricao" => "",
    "editora" => "",
    "genero" => "",
);

$cabecalho_base = array(
    "Content_type" => "application/json",
    "Authorization" => "Bearer "
);

$cliente_API =  new GuzzleClient([
    'base_uri' => "localhost:8000"
]);

popen("cls","w");
$logado = false;
while(true){
    echo "|----------Biblioteca_IFRN----------|\n";

    foreach($options as $key => $value){
        if($logado){
            $value = str_replace("#", "", $value);
            echo $key ."-". $value ."\n";
        }else{
            echo $key ."-". $value ."\n";
        }
    }
    $option = readline();
    switch($option){
        case "1":
            popen("cls","w");
            echo"\n-----Login-----\n";
            echo "Digite sua matricula:\n";
            $matricula = readline();
            echo "Digite sua senha:\n";
            $senha = Seld\CliPrompt\CliPrompt::hiddenPrompt();
            $token = login($matricula, $senha);
            $cabecalho_base["Authorization"] = "Bearer ".$token;
            $logado = true;
        break;
        case "2":
            $resp = $cliente_API->get('/api/livros');
            $resp_json = json_decode($resp->getBody()->getContents(), true);

            echo "\n-----".$resp_json['message']."-----\n";
            foreach ($resp_json["result"] as $item) {
                echo $item["id"]." - ".$item["titulo"] . "\n";
            }
            echo"\n";
            break;
        case "3":
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
            try{
                $resp = $cliente_API->post('/api/livros',[
                    'headers' => $cabecalho_base,
                    'json' => $form
                ]);
            }catch(ClientException  $e){
                if($e->getResponse()->getStatusCode() == 401){
                    echo "--VOCE PRECISA ESTAR AUTENTICADO--\n";
                }
                break;
            }
            echo "--LIVRO CADASTRADO COM SUCESSO--\n";

            break;
        case "4":
            popen("cls","w");
            echo"\n-----Exibir Livro-----\n";
            echo "Digite o id do livro\n";
            $id = intval(readline());
            try{
                $resp = $cliente_API->get("/api/livros/{$id}");
            }catch(ClientException  $e){
                if($e->getResponse()->getStatusCode() == 404){
                    echo "--O LIVRO NAO EXISTE--\n";
                }
                break;
            }
            echo "--LIVRO ENCONTRADO--\n";
            
            $resp_json = json_decode($resp->getBody()->getContents(), true);

            echo "\n-----".$resp_json['message']."-----\n";
            
            foreach ($resp_json["result"] as $key => $value) {
                if($key == "remember_token" || $key == "created_at" || $key == "updated_at"){
                    continue;
                }
                echo ucfirst("$key: ").$value."\n";
            }
            echo "\n";
            break;
        case "5":
            popen("cls","w");
            echo"\n-----Editar Livro-----\n";
            echo "Digite o id do livro\n";
            $id = intval(readline());

            try{
                $resp = $cliente_API->get("/api/livros/{$id}");
            }catch(ClientException  $e){
                if($e->getResponse()->getStatusCode() == 404){
                    echo "--O LIVRO NAO EXISTE--\n";
                }
                break;
            }
            
            $resp_json = json_decode($resp->getBody()->getContents(), true);
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
            
            try{
                $resp = $cliente_API->put("/api/livros/{$id}",[
                    'headers' => $cabecalho_base,
                    'json' => $form
                ]);
            }catch(ClientException  $e){
                if($e->getResponse()->getStatusCode() == 401){
                    echo "--VOCE PRECISA ESTAR AUTENTICADO--\n";
                }
                break;
            }

            if($resp->getStatusCode() == "200"){
                echo "-----LIVRO EDITADO COM SUCESSO----\n";
            }

            break;
        case "6":
            popen("cls","w");
            echo"\n-----Excluir Livro-----\n";
            echo "Digite o id do livro\n";
            $id = intval(readline());
            try{
                $resp = $cliente_API->head("/api/livros/{$id}");
            }catch(ClientException  $e){
                if($e->getResponse()->getStatusCode() == 404){
                    echo "--LIVRO NÃO EXISTE--\n";
                }
                break;
            }

            if($resp->getStatusCode() == "200"){
                try{
                    $resp = $cliente_API->delete("/api/livros/{$id}",[
                    'headers' => $cabecalho_base
                    ]);
                }catch(ClientException  $e){
                    if($e->getResponse()->getStatusCode() == 401){
                        echo "--VOCE PRECISA ESTAR AUTENTICADO--\n";
                    }
                    break;
                }
                echo "--LIVRO DELETADO--\n";
            }
            break;
        case "7":   
            return false;
            break;
        default:
            echo "--Número inválido--\n";
            break;
    }
}
?>