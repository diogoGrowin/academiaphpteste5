<?php

namespace app;                  //define namespace

use app\DatabaseObject;      //include another class by is namespace\class file name

use PDO;    //need to use PDO

class LogModel extends DatabaseObject
{
    protected static $table_name='logs';      								//db name
    protected static $db_columns=['username','action','time_stamp','description'];      	//db columns

    public $username;
    public $action;
    public $time_stamp;
    public $description;

    public function __construct($args=[])
    {
        $this->username=isset($args['username']) ? $args['username'] : '';
        $this->action=isset($args['action']) ? $args['action'] : '';
        $this->time_stamp=isset($args['time_stamp']) ? $args['time_stamp'] : '';
        $this->description=isset($args['description']) ? $args['description'] : '';
    }

    public static function getRowObject()
    {
        $sql='select * from logs';

        $stmt= self::$db->prepare($sql);
        
        try
        {
            self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
            $res=$stmt->execute();
            return $stmt;
        }catch(PDOException $e)
        {   
            die("Não foi possível retornar os logs".'<br/><br/>'.$e->getMessage().'<br/><br/>'.$stmt->debugDumpParams());    
        }
    }

}




?>