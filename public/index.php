<?php
    include('../vendor/boot.php');
?>

    <?php
        // LOADER BEGIN (from .htaccess)

        //came on .htaccess file redirect
        $controller = $_GET['ct'] ?? '';    //parameter on URL redirect on .htaccess for controller name
        $method = $_GET['mt'] ?? '';        //parameter on url redirect on .htaccess for method name 

        #echo $_SERVER['REDIRECT_QUERY_STRING'];    //display if redirect

        $data ='';
    

        //var_dump($_POST);
        #var_dump(file_get_contents('php://input'));
       // echo 'ola';
       

        if($_POST)  //check if any data from forms came together
        {
            $data = $_POST;
        }
        
        $ns = "app\controller\\" . $controller; //namespace dynamic


        //if not method or controller then send to login
        if(empty($controller) || empty($method))
        {   
            //redirecto to /login, which will be captured on .htaccess and send to login page again
            header('location: /login');
        }

        if($data)
        {   
            $ct = new $ns;
            $return = $ct->$method($data);
            print_r($return);
        }else 
        {
           $ct = new $ns;
           $ct->$method();
        }

    ?>
