<?php

namespace app\controller;

use app\UserModel;
use app\LogModel;

use app\controller\LogController;

use app\controller\mailController;


class UserController
{
    public $errors = array();               //errors
    protected $hashed_password;             //outside of this class cannot access it

    //generate random string
    public function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function set_hashed_password()
    {     
      //encrypt password
      #$this->hashed_password=password_hash(generateRandomString(),PASSWORD_BCRYPT);
      return password_hash($this->generateRandomString(),PASSWORD_BCRYPT);
    }

    //check if password matches to login user
    public function verify_password($password,$user)
    {
      return password_verify($password,$user->hashed_password);
    }


    public function validate($args=[])
    {   
        $this->errors=[];   //clear errors

        if(isset($args['username']) && $args['username'] == '')
        {
            $this->errors['errors'][]='Username cannot be blank.';
        }

        if(isset($args['password']) && $args['password'] == '')
        {
            $this->errors['errors'][]='Pasword cannot be blank.';
        }
    }

    public function validate_new($args=[])
    {   
        $this->errors=[];

        if($args['first_name'] == '')
        {
            $this->errors['errors'][]='First name cannot be blank.';
        }elseif(strlen($args['first_name']) < 3)
        {
            $this->errors['errors'][]='First name must be at least 3 characters';
        }

        if($args['last_name'] == '')
        {
            $this->errors['errors'][]='Last name cannot be blank.';
        }elseif(strlen($args['last_name']) < 3)
        {
            $this->errors['errors'][]='Last name must be at least 3 characters';
        }

        if($args['email'] == '')
        {
            $this->errors['errors'][]='Email cannot be blank.';
        }

        if($args['username'] == '')
        {
            $this->errors['errors'][]='Username cannot be blank.';
        }elseif(strlen($args['username']) < 5)
        {
            $this->errors['errors'][]='Username name must be at least 5 characters';
        }

        if($args['password'] == '')
        {
            $this->errors['errors'][]='Password cannot be blank.';
        }elseif(strlen($args['password']) < 5)
        {
            $this->errors['errors'][]='Password must be at least 5 characters';
        }

        if($args['confirm_password'] == '')
        {
            $this->errors['errors'][]='Confirm Password cannot be blank.';
        }elseif(strlen($args['confirm_password']) < 5)
        {
            $this->errors['errors'][]='Confirm Password must be at least 5 characters';
        }elseif($args['confirm_password'] !== $args['password'])
        {
            $this->errors['errors'][]='Confirm Password must match with password';
        }

    }

    public function modify()
    {   
        $hash_code = isset($_POST['hash_code']) ? $_POST['hash_code'] : '';
        $new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : '';

        //write log function
        $log_params=[];
        $log_params['username']='';
        $log_params['action']='modify of new user';

        $temp_user = UserModel::find_by_hash($hash_code);       //search user with hash

        if($temp_user)
        {
      
        #return json_encode(['message' => 'user details: '. $temp_user->email]);
        //exit();

        $current_time=date("Y-m-d H:i:s");               //get current time to compare
        $diff = abs(strtotime($current_time) - strtotime($temp_user->time_stamp))/60 ;


        if($diff > 5)
        {   
            //user already expire
                      
        $log_params['time_stamp']=date("Y-m-d H-i-s");
        $log_params['description']='User '.' with IP: ' .$_SERVER['REMOTE_ADDR'].' try modify invalid user: '.$temp_user->first_name . ' !!User expired';
        LogController::write_log($log_params);

        return $json = json_encode(['message' => 'Error!! This user no longer available, it already expires!']);
                            
        }else
        {   
            #return json_encode(['message' =>  echo('aaaaaa') ]);

            //Modify password since user still available

            $temp_user->hashed_password = password_hash($new_pass,PASSWORD_BCRYPT);  //modify password on usermodel
            $temp_user->authorized = 1;
            #$res=$temp_user->update();        //update password on DB
            $res = UserModel::update_user($temp_user->id,$temp_user->hashed_password,$temp_user->authorized);

            #return json_encode(['message' => $temp_user->id. '--' . $temp_user->authorized . '--' .$temp_user->hashed_password ]);

            //modify users table to authorized be 1

            if($res)
            {   
                $log_params['time_stamp']=date("Y-m-d H-i-s");
                $log_params['description']='User '.' with IP: ' .$_SERVER['REMOTE_ADDR'].' modify invalid user: '.$temp_user->first_name  . ' successfully';
                LogController::write_log($log_params);

                return  $json = json_encode(['message' => 'Sucess updating user password!' ]);
            }else
            {
                return  $json = json_encode(['message' => 'Error updating' ]);
            }

        }

    }else
    {   
        $log_params['time_stamp']=date("Y-m-d H-i-s");
        $log_params['description']='User '.' with IP: ' .$_SERVER['REMOTE_ADDR'].' try modify invalid user !!!! User not found';
        LogController::write_log($log_params);
        return json_encode(['message' => 'User not found ']);        
    }

    }

    public function register()
    {   
        //write log function
        $log_params=[];
        $log_params['username']='';
        $log_params['action']='creation of new user';

        //parameters for the user
        $params=[];
        $params['first_name']='admin3';
        $params['email']='facexperiencia@gmail.com';
        $params['username']='admin3';
        $params['hashed_password'] = $this->set_hashed_password();  //get random hash for password
        $params['last_login']=date("Y-m-d H-i-s");
        $params['time_stamp']= date("Y-m-d H-i-s");
        $params['authorized']=0;

        $user = new UserModel($params);                             //create user

        //check if user already exist on DB
        if(UserModel::find_by_username($params['username']) )
        {   
            $log_params['time_stamp']=date("Y-m-d H-i-s");
            $log_params['description']='Error creating new user from IP: ' .$_SERVER['REMOTE_ADDR'] . '!! User already exists!';
            LogController::write_log($log_params);

            $json = json_encode(['message' => 'Error!!User already exist ! Register another different!']);
        }

        $res=$user->create();                                       //register user on DB

        if($res)
        {
            $mail = new mailController();           
            $mail->sendMail($user->email, $user->hashed_password);      //send email to user

            $json = json_encode(['message' => 'Sucess creating new user']);
        }else
        {
            $json = json_encode(['message' => 'Error!']);
        }


        $log_params['time_stamp']=date("Y-m-d H-i-s");
        $log_params['description']='User '.' with IP: ' .$_SERVER['REMOTE_ADDR'].' create user: '.$params['username'];
                    
        LogController::write_log($log_params);

        return $json;
    }

    public function login()
    {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        //write log function
        $log_params=[];
        $log_params['username']='';
        $log_params['action']='login';

        $user = UserModel::find_by_username($username); //find user by username

        if($user)   //if user exists
        { 
            //check password for user
            $res_pass=$this->verify_password($password,$user);  //check password for user
            
            if($res_pass)
            {   

                $res_authorized= UserModel::check_authorized($user->username); //check if user is authorized to login

                if($res_authorized)
                {
                    //password match
                    $login_time=date("Y-m-d H-i-s");
                    $hash=hash('md5',$user->username);      //generate hash

                    $user->update_user_login($user->id,$login_time,$hash);      //update user login last login and hash

                    $log_params['time_stamp']=date("Y-m-d H-i-s");
                    $log_params['description']='User '.$user->username .' with IP: ' .$_SERVER['REMOTE_ADDR'].' has been logged in ';
                                
                    LogController::write_log($log_params);

                    //success on login! need to return the hash to the next methods
                    $json = json_encode(['message' => 'Login successfull. ',
                                            'hash'=> $hash]);
                }else
                {   
                    $log_params['time_stamp']=date("Y-m-d H-i-s");
                    $log_params['description']='User '.$user->username .' with IP: ' .$_SERVER['REMOTE_ADDR'].' try to login but not authorized';
                                
                    LogController::write_log($log_params);

                    //user not authorized
                    $json = json_encode(['message' => 'Error!!! User not authorized']);
                    
                }

            }else
            {   
                $log_params['time_stamp']=date("Y-m-d H-i-s");
                $log_params['description']='User '.$user->username .' with IP: ' .$_SERVER['REMOTE_ADDR'].' fail login! Wrong credentials ';
                            
                LogController::write_log($log_params);

                $json = json_encode(['message' => 'Error!! Wrong credentials']);
            }

            return $json;

        }else
        {
            return $json = json_encode(['message' => 'Error!! Wrong user or password']);
        }

    }


    public function enviarMensagemBotSlack($email,$key,$user)
    {   //necessita instalação do modulo de php php-curl e depois reiniciar o apache
        $name = 'Diogo';
        $ch = curl_init("https://slack.com/api/chat.postMessage");

        $data = http_build_query([
            "token" => "xoxb-101259630004-520202224629-DPHnA8VClMhljp6nkOQzR5BH",
            "channel" => "#botecho",         // Canal para onde querem enviar mensagem no slack
            "text" => "(Diogo) Key to create new user: ".$key . ' for user: '. $user ."  and with email:  " .$email ,
            "username" => "AcademiaPHP Bot",
        ]);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);

            return true;
    }

    public static function verify_hash($hash)
    {
        return UserModel::confirm_hash($hash);
    }
}


?>