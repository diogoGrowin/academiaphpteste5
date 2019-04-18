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

  //method to check if user exist or not when try to login and when try to add another user
  public static function find_by_username($username)
  {
    $sql='select * from '.static::$table_name .' ';
    $sql .=' where username= ?';

    $stmt= self::$db->prepare($sql);       //bind parameter
    $stmt->bindParam(1,$username);

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

  public static function check_authorized($username)
  {
    $sql='select * from '.static::$table_name .' ';
    $sql .=' where username= ? and authorized =1';

    $stmt= self::$db->prepare($sql);       //bind parameter
    $stmt->bindParam(1,$username);

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

  public function update_user_login($id,$login_time,$hash)
  {
    $sql='update users set ';
    $sql .= 'last_login=:last_login, temp_hash=:temp_hash  where id = :id';

    $stmt= self::$db->prepare($sql);

    $stmt->bindParam(':last_login',$login_time);
    $stmt->bindParam(':temp_hash',$hash);
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

  public static function confirm_hash($hash)
  {
    $sql='select * from '.static::$table_name .' ';
    $sql .=' where temp_hash= ?';

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


}

?>