<?php
  session_start();

//paths do projecto
define("PROJECT_PATH",dirname(__DIR__));			// /var/www/projetophp.mvc
define("PUBLIC_PATH",PROJECT_PATH . '/public');		// /var/www/projetophp.mvc/Public

//encontrar dinamicamente a web root do projecto
$public_end= strpos($_SERVER['SCRIPT_NAME'],'/') +7 ; //+7 para ser a posição seguinte ao public path
$doc_root= substr($_SERVER['SCRIPT_NAME'],0,$public_end);
define ("WWW_ROOT",$doc_root);


//load db connection file and connection  
include(PROJECT_PATH.'/vendor/database.php');    //db connection file   

$db=vendor\db_connect();       //return the db connection


// Autoload class definitions
//NOTE: the name of the file class need to be lowercase ! and the name of the folder too !! or need to change the path and file name
function my_autoload($className)
{
    //use this with namespaces 
    $filename = PROJECT_PATH . "/" . str_replace("\\", '/', $className) . ".php";
    $filename = strtolower($filename);

    if (file_exists($filename)) 
    {
        include($filename);
        if (class_exists($className)) 
        {
          return TRUE;
        }
    }
    return FALSE;
    
}

spl_autoload_register('my_autoload');

//set DB connection on class, so class can use that DB connection  
app\DatabaseObject::set_database($db);   //active record design pattern with namespaces


//create session object
#$session = new app\controller\Session();

//include composer autoload
include(PROJECT_PATH.'/vendor/autoload.php');

//include configuration file for swift mailer
include(PROJECT_PATH . '/vendor/config.php');       

?>