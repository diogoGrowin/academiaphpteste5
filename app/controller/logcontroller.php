<?php

namespace app\controller;

use app\LogModel;
use vendor\template;

use vendor\Foundationphp\Exporter\Csv;

use app\controller\UserController;

/* use vendor\Foundationphp\Psr4Autoloader;

$loader = new vendor\Foundationphp\Psr4Autoloader();
$loader->register();
$loader->addNamespace('Foundationphp', 'classes/Foundationphp'); */

class LogController
{
    public static function display_logs()
    {
        return LogModel::find_all();
    }

    public static function count_logs()
    {
        return LogModel::count_records();
    }

    public static function write_log($log_params)
    {
        
        $log = new LogModel($log_params);
        $log->save();
    }

    public function download()
    {  
        //write log function
        $log_params=[];
        $log_params['username']='';
        $log_params['action']='access methods';
    
       $hash = isset($_POST['hash_code']) ? $_POST['hash_code'] : '';
       #return  $json = json_encode(['message' => 'hash code: '. $hash ]);

        if(empty($hash))
        {   
            $log_params['time_stamp']=date("Y-m-d H-i-s");
            $log_params['description']='Someone with IP: ' .$_SERVER['REMOTE_ADDR'].' try to execute method download without login ';
            LogController::write_log($log_params);

            return $json = json_encode(['message' => 'Error!! cannot execute this method without login first' ]);
        }else
        {   
            //check hash for user
            $res_hash=UserController::verify_hash($hash);

            if($res_hash)
            {   
                //retrive all logs
                $logs=LogModel::find_all();
                
                $final_location="/var/www/academiaphpteste5.teste/files_download/logs_".date("Y-m-d_H-i-s").".csv";
            
                $size = count($logs);   // tamanho do array
            
                $keys = array_keys($logs);  // array que vai guardar todos os campos chave do input
           
                $headerContent=[];
                $fileContent=[];

                for($i = 0; $i < $size-1; $i++) 
                {
                    $fileContent[]=$logs[$keys[$i]];  //armazenar value num novo array
                    $headerContent[]=$keys[$i];         //armazena as keys num novo array
                }   

                if ($myfile = fopen($final_location, "a+")) 
                {   //verifica se o ficheiro existe
                    fputcsv($myfile,$fileContent);          //escrever no ficheiro csv todas os values correspondentes
                } else {
                    $myfile = fopen($final_location, "a+") or die("Impossivel modificar ficheiro");     //cria o ficheiro pois não existe
                    fputcsv($myfile,$headerContent);        //escrever no ficheiro csv todos as keys
                    fputcsv($myfile,$fileContent);          //escrever no ficheiro csv todas os values correspondentes
                }
                
                fclose($myfile);

                $log_params['time_stamp']=date("Y-m-d H-i-s");
                $log_params['description']='User with IP: ' .$_SERVER['REMOTE_ADDR'].' download with successfull the csv file';
                LogController::write_log($log_params);

                return $json = json_encode(['message' => 'Success!! Download successfull' ]);
            }else
            {   
                $log_params['time_stamp']=date("Y-m-d H-i-s");
                $log_params['description']='Someone with IP: ' .$_SERVER['REMOTE_ADDR'].' try to execute method download without login ';
                LogController::write_log($log_params);
                return $json = json_encode(['message' => 'Error!! user not logged in' ]);
            }
        }
        
       /* try
        {
            $result=LogModel::getRowObject();

            $options['delimiter'] = "\t";

            new Csv($result,'logs.csv',$options);

        }catch(Exception $e)
        {
            die('Impossivel fazer download de momento!!');
        } */
    }

}



?>