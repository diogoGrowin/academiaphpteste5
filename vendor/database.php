<?php

namespace vendor;   //define namespace

use PDO;    //use PDO DB

//define db constants
define('DB_SERVER','10.2.40.94');
define('DB_USER','diogo');
define('DB_PASS','teste123');
define('DB_NAME','teste5');

function db_connect()
{  

    try
    {   
        //connect to a DB by PDO and return the connection
        $conn=new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME,DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
        return $conn;
            
    }catch (PDOException $e)
    {
        //if error, catch the error and return it
        #$_SESSION['erros'][]='Erro ao ligar a BD. '. $e->getMessage();    //obter erros senão for possível ligar a BD
        die('Erro to connect on DB'. $e->getMessage());
    }

}








?>