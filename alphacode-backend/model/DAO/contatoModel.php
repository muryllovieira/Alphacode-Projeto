<?php 
    /***********************************************************************************
     * Objetivo: Arquivo responsavel por manipular os dados de contato dentro do BD 
     *      (insert, update, select e delete)
     * Autor: Muryllo Vieira
     * Data: 21/12/2023
     * Versão: 1.0
    ************************************************************************************/
    
    //import do arquivo que estabece a conexão com o BD
    require_once('./model/bd/conexao_mysql.php');

    //Função para realizar o insert no BD
    function insertContato($dadosContato)
    {
        //declaração de variavel para utilizar no return desta função
        $statusResposta = (boolean) false;

        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //Monta o script para enviar para o BD
        $sql = "insert into tbl_usuario 
                    (nome, 
                    email, 
                    telefone, 
                    data_nascimento, 
                    profissao, 
                    celular,
                    whatsapp,
                    notificacao_sms,
                    notificacao_email
                )
                values 
                    ('".$dadosContato['nome']."', 
                    '".$dadosContato['email']."', 
                    '".$dadosContato['telefone']."', 
                    '".$dadosContato['data_nascimento']."', 
                    '".$dadosContato['profissao']."',
                    '".$dadosContato['celular']."',
                    ".$dadosContato['whatsapp']. ",
                    ".$dadosContato['notificacao_sms'].",
                   ".$dadosContato['notificacao_email']."
                );";

       
        //Executa o script no BD
            //Validação para verificar se o script sql está correto
        if (mysqli_query($conexao, $sql))
        {   
            //Validação para verificar se uma linha foi acrescentada no DB
            if(mysqli_affected_rows($conexao))
                $statusResposta = true;
        }
        

        return $statusResposta;

    }

    //Função para realizar o update no BD
    function updateContato($dadosContato)
    {
        //declaração de variavel para utilizar no return desta função
        $statusResposta = (boolean) false;

        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //Monta o script para enviar para o BD
        $sql = "update tbl_usuario set 
                        nome                = '".$dadosContato['nome']."', 
                        email               = '".$dadosContato['email']."', 
                        telefone            = '".$dadosContato['telefone']."', 
                        data_nascimento     = '".$dadosContato['data_nascimento']."', 
                        profissao           = '".$dadosContato['profissao']."',
                        celular             = '".$dadosContato['celular']."',
                        whatsapp            = '".$dadosContato['whatsapp']."',
                        notificacao_sms    = '".$dadosContato['notificacao_sms']."',
                        notificacao_email  = '".$dadosContato['notificacao_email']."'
                where id =".$dadosContato['id'];
       
        //Executa o scriipt no BD
            //Validação para veririficar se o script sql esta correto
        if (mysqli_query($conexao, $sql))
        {   
            //Validação para verificar se uma linha foi acrescentada no DB
            if(mysqli_affected_rows($conexao))
                $statusResposta = true;
        }
        
     
        return $statusResposta;

    }

    //Função para excluir no BD
    function deleteContato($id)
    {
        //declaração de variavel para utilizar no return desta função
        $statusResposta = (boolean) false;

        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //Script para deletar um registro do BD
        $sql = "delete from tbl_usuario where id =".$id;

        //Valida se o script esta correto, sem erro de sintaxe e executa no BD
        if(mysqli_query($conexao, $sql))
        {
            //Valida se o BD teve sucesso na execução do script
            if(mysqli_affected_rows($conexao))
                $statusResposta = true;
        }

        return $statusResposta;
    }

    //Função para listar todos os contatos do BD
    function selectAllContatos()
    {
        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //script para listar todos os dados do BD
        $sql = "select * from tbl_usuario";
        
        //Executa o script sql no BD e guarda o retorno dos dados, se houver
        $result = mysqli_query($conexao, $sql);

        //Valida se o BD retornou registros
        if($result)
        {
            $cont = 0;
            while ($rsDados = mysqli_fetch_assoc($result))
            {
                //Cria um array com os dados do BD
                $arrayDados[$cont] = array (
                    "id"                 =>  $rsDados['id'],
                    "nome"               =>  $rsDados['nome'],
                    "email"              =>  $rsDados['email'],
                    "telefone"           =>  $rsDados['telefone'],
                    "data_nascimento"    =>  $rsDados['data_nascimento'],
                    "profissao"          =>  $rsDados['profissao'],
                    "celular"            =>  $rsDados['celular'],
                    "whatsapp"           => $rsDados['whatsapp'],
                    "notificacao_sms"    => $rsDados['notificacao_sms'],
                    "notificacao_email"  => $rsDados['notificacao_email']
                );
                $cont++;
            }
    
            //select id from tbl_usuario order by id desc limit 1
            if(isset($arrayDados))
                return $arrayDados;
            else
                return false;
        }

    }

    //Função para buscar um contato no BD através do id do registro
    function selectByIdContato($id)
    {
        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //script para listar todos os dados do BD
        $sql = "select * from tbl_usuario where id = ".$id;
        
        //Executa o script sql no BD e guarda o retorno dos dados, se houver
        $result = mysqli_query($conexao, $sql);

        //Valida se o BD retornou registros
        if($result)
        {
            //mysqli_fetch_assoc() - permite converter os dados do BD 
            //em um array para manipulação no PHP
            //Nesta repetição estamos, convertendo os dados do BD em um array ($rsDados), além de
            //o próprio while conseguir gerenciar a qtde de vezes que deverá ser feita a repetição
            
            if ($rsDados = mysqli_fetch_assoc($result))
            {
                //Cria um array com os dados do BD
                $arrayDados = array (
                    "id"                 =>  $rsDados['id'],
                    "nome"               =>  $rsDados['nome'],
                    "email"              =>  $rsDados['email'],
                    "telefone"           =>  $rsDados['telefone'],
                    "data_nascimento"    =>  $rsDados['data_nascimento'],
                    "profissao"          =>  $rsDados['profissao'],
                    "celular"            =>  $rsDados['celular'],
                    "whatsapp"           => $rsDados['whatsapp'],
                    "notificacao_sms"    => $rsDados['notificacao_sms'],
                    "notificacao_email"  => $rsDados['notificacao_email']
                );
            }
        }    

            
            if(isset($arrayDados))
                return $arrayDados;
            else
                return false;
    }

?>