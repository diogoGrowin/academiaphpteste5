<?php

namespace app;                  //define namespace

use app\DatabaseObject;      //include another class by is namespace\class file name

use PDO;    //need to use PDO

class UserModel extends DatabaseObject
{

    protected static $table_name='users';      								//db name
    protected static $db_columns=['first_name','email','username','hashed_password','last_login','time_stamp','authorized'];      	//db columns
    

    public $id;
    public $first_name;
    public $email;
    public $username;
    public $last_login;
    public $time_stamp;
    public $authorized;
    
    public $hashed_password;
    #protected $password_required=true;      //check if password is required or not
    
    #public $password;
    #public $confirm_password;

    public function __construct($args=[])
    {
        $this->first_name = $args['first_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->hashed_password = $args['hashed_password'] ?? '';
        $this->last_login = $args['last_login'] ?? '';
        $this->time_stamp = $args['time_stamp'] ?? '';
        $this->authorized = $args['authorized'] ?? '';
    }

 
  //method to check if user exist or not when try to login and when try to add another user
  public static function find_by_hash($hash)
  {
    $sql='select * from '.static::$table_name .' ';
    $sql .=' where hashed_password= ?';

    $stmt= self::$db->prepare($sql);       //bind parameter
    $stmt->bindParam(1,$hash);

    #return self::find_by_sql($sql);
    $obj_array=static::find_by_sql($stmt);   //save result

    if(!empty($obj_array))                 //if result
    {
      return array_shift($obj_array);      //return 1º element, single records
    }else
    {
      return false;
    }
  }

  public static function update_user($id,$pass,$autorized)
  {
    $sql='update users set ';
    $sql .= 'hashed_password=:pass, authorized=:auth  where id = :id';

    $stmt= self::$db->prepare($sql);

    $stmt->bindParam(':pass',$pass);
    $stmt->bindParam(':auth',$autorized);
    $stmt->bindParam(':id',$id);

    try
    {
      self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
      $res=$stmt->execute();
      return $res;
    }catch(PDOException $e)
    {   
        die("Não foi possível atualizar o contato.".'<br/><br/>'.$e->getMessage().'<br/><br/>'.$stmt->debugDumpParams());    
    }

  }

  public function temporary_save_user($args,$hash)
  {   
      $sql = 'insert into temp_users ';
      $sql .="(first_name,last_name,email,username,hashed_password,hash_key_creation) ";    
      $sql .="values(:first_name ,"; 
      $sql .=":last_name ,"; 
      $sql .=":email ,"; 
      $sql .=":username ,"; 
      $sql .=":hashed_password ,"; 
      $sql .=":hash_key_creation );"; 

      $stmt= self::$db->prepare($sql);
  
      $stmt->bindValue(':first_name',$args['first_name']);
      $stmt->bindValue(':last_name',$args['last_name']);
      $stmt->bindValue(':email',$args['email']);
      $stmt->bindValue(':username',$args['username']);
      $stmt->bindValue(':hashed_password',password_hash($args['password'],PASSWORD_BCRYPT));
      $stmt->bindValue(':hash_key_creation',$hash);

      try
      {
        self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR
        $stmt->execute();
        return true;
      }catch(DPOException $e)
      {
          //works fine, but need to be enabled(1º line on try)
          die("Não foi possível criar o utilizador temporario.".'<br/><br/>'.$e->getMessage().'<br/><br/>'.$stmt->debugDumpParams());
      }
  }

  public static function get_temporary_user($key)
  {
      $sql = 'select * from temp_users where hash_key_creation = ? limit 1;';
  
      $stmt= self::$db->prepare($sql);
      $stmt->bindParam(1,$key);
  
      try
      {
        self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR
        $stmt->execute();           //execute the prepared statement
        $result = $stmt->fetch();   //run single record and save the result on array. Need a loop to run all lines with fetch
        return $result;
      }catch(PDOException $e)
      {
          die("Não foi possível realizer a pesquisa do contato.".'<br/>'.$e->getMessage().'<br/><br/>'.$stmt->debugDumpParams());    //works fine, but need to be enabled(1º line on try)
      }
  }

  public function delete_temporary_user($key)
  {
      $sql="delete from temp_users ";       //query
      $sql .= "where hash_key_creation = ? limit 1;";   

      $stmt= self::$db->prepare($sql);
      $stmt->bindParam(1,$key);

      try{
        self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR
        $stmt->execute();
        return true;
      }catch(PDOException $e)
      {   
          die("Não foi possível apagar o contato.".'<br/>'.$e->getMessage());    //works fine, but need to be enabled(1º line on try)
      }
  }


}

?>