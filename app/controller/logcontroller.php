<?php

namespace app\controller;

use app\LogModel;
use vendor\template;

use vendor\Foundationphp\Exporter\Csv;

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

    public function display_all()
    {   
        $view=new Template();

        //check if session exists, to validate
        if(isset($_SESSION['user_id']))
        {   
            $logs_set=LogController::display_logs();

            $number_logs=LogController::count_logs();
    
            //write log function
            $log_params=[];
            if(isset($_SESSION['username']))
            {
                    $log_params['username']=$_SESSION['username'];
            }else
            {
                    $log_params['username']='';
            }
            $log_params['action']='view all logs';
            $log_params['time_stamp']=date("Y-m-d H-i-s");
            $log_params['description']='User '. $_SESSION['username'] .' with IP: ' .$_SERVER['REMOTE_ADDR'].' click option view all logs';
    
            LogController::write_log($log_params);
    
            $view->render('show_logs.view.php',$logs_set,$number_logs);
            exit();
        }
        else
        {
            $view->render('login.php');
        }        
    }

    public function download()
    {
        try
        {
            $result=LogModel::getRowObject();

            $options['delimiter'] = "\t";

            new Csv($result,'logs.csv',$options);

        }catch(Exception $e)
        {
            die('Impossivel fazer download de momento!!');
        }
    }

}



?>