<?php
/**********************************************************************************
 * Objetivo: Arquivo para criar a conexão com o BD Mysql
 * Autor: Muryllo Vieira
 * Data: 21/12/2023
 * Versão: 1.0
 ***********************************************************************************/

//constantes para estabelecer a conexão com o BD (local do BD, usuário, senha e database)
const SERVER = 'localhost';
const USER = 'root';
const PASSWORD = '15022005';
const DATABASE = 'alphacode_db';

 //Abre a conexão com o BD Mysql
 function conexaoMysql()
 {      
    $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    if ($mysqli->connect_errno) {
        echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } 

    return $mysqli;

 }

?>