<?php

/***********************************************************************
 * Objetivo: Arquivo responsavel para a crição dos EndPoints da API
 * Autor: Muryllo
 * Data: 21/12/2023
 * Versão: 1.0
 ************************************************************************/

/*****
 *  $request    - Recebe dados do corpo da requisição (JSON, FORM/DATA, XML, etc)
 *  $response   - Envia dados de retorno da API
 *  $args       - Permite receber dados de atributos na API
 *  
 *  Os metodos de requisição para uma API são:
 *  GET         - para buscar dados
 *  POST        - para inserir um novo dado
 *  DELETE      - para apagar dados
 *  PUT/PATCH   - para editar um dados já existente
 *          O mais utilizado é o PUT 
 * 
 * *****/

//import do arquivo autoload, que fara as instancias do slim
require_once('./vendor/autoload.php');
require_once('./controller/contatoController.php');
include('./modulo/config.php');

header("Access-Control-Allow-Origin: *");

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json');

$config = ['settings' => ['displayErrorDetails' => true]];
//Criando um objeto do slim chamado app, para configurar os EndPoints
$app = new \Slim\App($config);

//Endpoint para retornar todos os contatos
$app->get('/contatos', function ($request, $response, $args) {

    if ($dados = listarContato()) {
        if ($dadosJSON = createJSON($dados)) {
            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write($dadosJSON);
        }
    } else {
        return $response->withStatus(204);
    }
});

//Endpoint para retornar um contato pelo ID
$app->get('/contato/{id}', function ($request, $response, $args) {

    $id =  $args['id'];
    $dados = buscarContatoPeloId($id);
    $status = (int) json_encode($dados['status']);

        return $response    ->withStatus($status)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode($dados));
});

//Endpoint para adicionar um contato
$app->post('/contato', function ($request, $response, $args) {

    $contentTypeHeader = $request -> getHeaderLine('Content-Type');
    $contentType =  explode(";", $contentTypeHeader);

    if ($contentType[0] == 'application/json') {

        $dadosBody = $request -> getParsedBody();

        $dadosArray = array($dadosBody);

        $dados = inserirContato($dadosArray);

        $status = (int) json_encode($dados['status']);

        return $response    ->withStatus($status)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode($dados));

    } else {

        $dados = array(
            'status' => 415,
            'message' => 'O tipo de mídia Content-Type da solicitação não é compatível com o servdor. Tipo aceito: [application/json]'
        );

        return $response    ->withStatus(415)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode($dados));
    }

});

//Endpoint para fazer a atualização dos dados do contato
$app->put('/contato/{id}', function ($request, $response, $args){

    $idContato = $args['id'];
    $contentTypeHeader = $request -> getHeaderLine('Content-Type');
    $contentType = explode(";", $contentTypeHeader);

    if ($contentType[0] == 'application/json') {

        $dadosBody = $request->getParsedBody();

        $dadosArray = array($dadosBody);

        $dados = atualizarContato($dadosArray, $idContato);

        $status = (int) json_encode($dados['status']);

        return $response->withStatus($status)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dados));
        
    } else {

        $dados = array(
            'status' => 415,
            'message' => 'O tipo de mídia Content-Type da solicitação não é compatível com o servdor. Tipo aceito: [application/json]'
        );

        return $response->withStatus(415)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dados));
    }
});

//Endpoint para deletar um contato
$app->delete('/contato/{id}', function ($request, $response, $args) {
    $id = $args['id'];

    $dados = deletarContato($id);
    $status = (int)json_encode($dados['status']);

    return $response    ->withStatus($status)
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode($dados));
});


$app->run();
