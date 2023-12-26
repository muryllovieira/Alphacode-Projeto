<?php
    /**************************************************************************************
     * Objetivo: Arquivo responsavel pela criação de variaveis e constantes do projeto
     * Autor: Muryllo Vieira
     * Data: 21/12/2023
     * Versão: 1.0
    ****************************************************************************************/

    /*************** FUNÇÕES GLOBAIS PARA O PROJETO ************ */

    //função para converter um array em um formato JSON
    function createJSON ($arrayDados)
    {
        //Validação para tratar array sem dados
        if (!empty($arrayDados))
        {
            //configura o padrão da conversão para o formato JSON
            header('Content-Type: application/json');
            $dadosJSON = json_encode($arrayDados);
            
            //json_encode(); - converte um array para JSON
            //json_decode(); - converte um JSON para array

            return $dadosJSON;
        }else
        {
            return false;
        }
        

    }
   


?>