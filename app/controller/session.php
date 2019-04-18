<?php

namespace app\controller;

//class to keep the session for the logged in user 

class Session
{
    private $user_id;

    public $username;   //display username value when logged in
    
    private $last_login;    //store the last login time

    public const MAX_LOGIN_AGE=60*60*24;        //max time logged in (1 day)
    #public const MAX_LOGIN_AGE=15;        //max time logged in (15 seconds)

    public function __construct()
    {   
       if(!$this->check_stored_login())
       {
            session_start();     // turn on sessions if needed
       };    
    }

    public function login($user)
    {
        //function to login and create the session for the user
        if($user)
        {   
            session_regenerate_id();    //protect fixation against session attacks

            $_SESSION['user_id'] = $user->id;
            $this->user_id=$user->id;         //store the id from the user in the private property

            //double assignment
            $this->username= $_SESSION['username'] = $user->username;   //stored username value when login

            $this->last_login= $_SESSION['last_login'] = time();
        }
        return true;
    }

    
    public function is_logged_in(): bool
    {
        //check if user logged in and is not logged in for longer than we should be
        return isset($this->user_id) && $this->last_login_is_recent();
    }

    public  function logout()         //<<-- original, is not static
    //public static function logout()     //modified
    {
        //function to logout the user
        unset($_SESSION['user_id']);       //unset session
        unset($this->user_id);             //unset the property

        unset($_SESSION['username']);
        unset($this->username);  

        unset($_SESSION['last_login']);
        unset($this->last_login);  

        session_destroy();      //destroy session
        session_unset();        //clear the session

        return true;
    }

    //check if was logged in previously, and if it is , then incorporate that session instead of create new
    private function check_stored_login()
    {
        if(isset($_SESSION))
        {
            $this->user_id= isset($_SESSION['user_id']);
            $this->username= isset($_SESSION['username']);
            $this->last_login= isset($_SESSION['last_login']); 

            return true;
        }

    }

    //check for max time logged in 
    private function last_login_is_recent()
    {
        if(!isset($this->last_login))
        {
            return false;
        }elseif(($this->last_login + self::MAX_LOGIN_AGE) < time())   //check for max logged in time
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //display session messages(no argument) or set messages(with argument)
    public function message($msg="")
    {
        if(!empty($msg))
        {
            //then set message since its not empty
            $_SESSION['message']=$msg;
            #var_dump($_SESSION['message']);
            #exit();
            return true;
        }
        else
        {
            //get message
           # return isset($_SESSION['message']) ? $_SESSION['message'] : '';
           return $_SESSION['message'] ?? '';
        }
    }

    public function clear_message()
    {
        unset($_SESSION['message']);
    }

  /*  public static function get_current_session()
    {
        $session_obj=array();
        $session_obj[]=$this->user_id;
        $session_obj[]=$this->username;
        $session_obj[]= $this->last_login;
        #$this->username= $_SESSION['username'];
        #$this->last_login= $_SESSION['last_login']; 
        return $session_obj;
    } */

}

?>