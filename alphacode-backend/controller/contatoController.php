<?php

/***********************************************************************
 * Objetivo: Arquivo responsavel para gerenciamento de dados que chegam do banco de dados
 * Autor: Muryllo
 * Data: 21/12/2023
 * Versão: 1.0
 ************************************************************************/

// //import do arquivo de configuração do projeto
// require_once('./modulo/config.php');

//import do arquivo que vai buscar os dados no DB
require_once('./model/DAO/contatoModel.php');

//Função para solicitar os dados da model e encaminhar a lista 
//de contatos para a View
function listarContato()
{
    //chama a função que vai buscar os dados no BD
    $dados = selectAllContatos();

    if (!empty($dados))
        return array(
            'status' => 200,
            'message' => 'Requisição bem sucedida',
            'contatos' => $dados
        );
    else
        return false;
}

function buscarContatoPeloId($id)
{

    if ($id != 0 && !empty($id) && is_numeric($id)) {

        $dados = selectByIdContato($id);

        if (!empty($dados))
            return array(
                'status' => 200,
                'message' => 'Requisição bem sucedida',
                'contato' => $dados
            );
        else
            return false;
    } else {

        $dados = array(
            'status' => 400,
            'message' => 'O ID encaminhado não é válido'
        );

        return $dados;
    }
}

function inserirContato($dadosContato)
{

    if (
        !empty($dadosContato[0]['nome'])            &&  !is_int($dadosContato[0]['nome'])           && strlen($dadosContato[0]['nome']) <= 100 &&
        !empty($dadosContato[0]['email'])           && !is_int($dadosContato[0]['email'])           && strlen($dadosContato[0]['email']) <= 100 &&
        !empty($dadosContato[0]['telefone'])        && !is_int($dadosContato[0]['telefone'])        && strlen($dadosContato[0]['telefone']) <= 100 &&
        !empty($dadosContato[0]['data_nascimento']) && !is_int($dadosContato[0]['data_nascimento']) &&
        !empty($dadosContato[0]['profissao'])       && !is_int($dadosContato[0]['profissao'])       && strlen($dadosContato[0]['profissao']) <= 100 &&
        !empty($dadosContato[0]['celular'])         &&  !is_int($dadosContato[0]['celular'])        && strlen($dadosContato[0]['celular']) <= 100
    ) {
        $dadosArray = array(
            "nome"              => $dadosContato[0]['nome'],
            "email"             => $dadosContato[0]['email'],
            "telefone"          => $dadosContato[0]['telefone'],
            "data_nascimento"   => $dadosContato[0]['data_nascimento'],
            "profissao"         => $dadosContato[0]['profissao'],
            "celular"           => $dadosContato[0]['celular'],
            "whatsapp"          => $dadosContato[0]['whatsapp'],                  
            "notificacao_sms"   => $dadosContato[0]['notificacao_sms'],
            "notificacao_email" => $dadosContato[0]['notificacao_email']
        );

        if (insertContato($dadosArray)) {

            return array(
                'status'   => 201,
                'message'  => 'Usuário inserido com sucesso',
                'dados'    => $dadosArray
            );
        } else {

            return array(
                'status'   => 500,
                'message'  => 'Não foi possivel inserir os dados no Banco de Dados',
            );
        }
    } else {

        return array(
            'status'   => 400,
            'message'  => 'Campos obrigatórios não foram preenchidos ou foram preenchidos de forma incorreta',
        );
    }
}

function atualizarContato($dadosContato, $idContato)
{
    if ($idContato != 0 && !empty($idContato) && is_numeric($idContato)) {

        if (selectByIdContato($idContato)) {
            if (
                !empty($dadosContato[0]['nome'])            &&  !is_int($dadosContato[0]['nome'])           && strlen($dadosContato[0]['nome']) <= 100 &&
                !empty($dadosContato[0]['email'])           && !is_int($dadosContato[0]['email'])           && strlen($dadosContato[0]['email']) <= 100 &&
                !empty($dadosContato[0]['telefone'])        && !is_int($dadosContato[0]['telefone'])        && strlen($dadosContato[0]['telefone']) <= 100 &&
                !empty($dadosContato[0]['data_nascimento']) && !is_int($dadosContato[0]['data_nascimento']) &&
                !empty($dadosContato[0]['profissao'])       && !is_int($dadosContato[0]['profissao'])       && strlen($dadosContato[0]['profissao']) <= 100 &&
                !empty($dadosContato[0]['celular'])         &&  !is_int($dadosContato[0]['celular'])        && strlen($dadosContato[0]['celular']) <= 100
            ) {

                $dadosArray = array(
                    "id"                => $idContato,
                    "nome"              => $dadosContato[0]['nome'],
                    "email"             => $dadosContato[0]['email'],
                    "telefone"          => $dadosContato[0]['telefone'],
                    "data_nascimento"   => $dadosContato[0]['data_nascimento'],
                    "profissao"         => $dadosContato[0]['profissao'],
                    "celular"           => $dadosContato[0]['celular'],
                    "whatsapp"          => $dadosContato[0]['whatsapp'],                  
                    "notificacao_sms"   => $dadosContato[0]['notificacao_sms'],
                    "notificacao_email" => $dadosContato[0]['notificacao_email']
                );

                if (updateContato($dadosArray)) {
                    return array(
                        'status'   => 200,
                        'message'  => 'Usuário atualizado com sucesso',
                        'dados'    => $dadosArray
                    );
                } else {
                    return array(
                        'status'   => 500,
                        'message'  => 'Não foi possivel atualizar os dados',
                    );
                }
            } else {
                return array(
                    'status'   => 400,
                    'message'  => 'Campos obrigatórios não foram preenchidos ou foram preenchidos de forma incorreta',
                );
            }
        } else {

            return array(
                'status'   => 404,
                'message'  => 'Nenhum contato encontrado'
            );
        }
    } else {
        return array(
            'status' => 400,
            'message' => 'O ID informado na requisição não é válido ou não foi encaminhado.'
        );
    }
}

function deletarContato($idContato){

    if ($idContato != 0 && !empty($idContato) && is_numeric($idContato)) {
        if(selectByIdContato($idContato)){
            if (deleteContato($idContato)) {
                return array(
                    'status' => 200,
                    'message' => "Usuário excluido com sucesso"
                );
            } else {
                return array(
                    'status'   => 500,
                    'message'  => 'Não foi possível deletar o contato selecionado'
                );
            }

        }else{
            return array(
                'status'   => 404,
                'message'  => 'O ID informado não é válido ou não foi encaminhado'
            );
        }
        
        
    }else{
        return array(
            'status' => 400,
            'message' => 'O ID informado não é válido ou não foi encaminhado'
        );
    }
}