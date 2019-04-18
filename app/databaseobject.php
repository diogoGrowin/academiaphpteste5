<?php

namespace app;  //need to define namespace

use PDO;    //need to use PDO

class DatabaseObject
{
    //properties that will be shared with subclasses
    protected static $db;                 //databse connection
    protected static $table_name='';      //db name
    protected static $db_columns=[];      //db columns
    
    public $errors=[];                   //validation errors

      /* -------------- START of ACTIVE RECORD CODE DESIGN PATTERN with ABSTRACT -------------- */
      //the following methods will be available for all classes that extends this one

    //this class will manage the DB connection, so before DB always use self::$db
    public static function set_database($db)
    {
      self::$db=$db;  //initialize static property $db and the DB will be always here, so use self !!
      //all references to DB always will be self, because it is this class who will always manage the DB connection
    }
  
    //function to execute any SQL statement
    public static function find_by_sql($stmt)
    {
      try
      {
        self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR
        
        //cannot prepare the sql inside this function, because some function will bind value(prepared stmts)
  
        $stmt->execute();                       //execute the prepared statement
    
        //put results into objects
        $object_array=[];
        while($result = $stmt->fetch())
        {
          $object_array[]=static::instantiate($result);    //method to instantiate the record as object,initialize the properties
        }
        return $object_array;   //return the array of objects
      }catch(PDOException $e)
      {
        //works fine, but need to be enabled(1º line on try)
        die("Não foi possível realizar a pesquisa .".'<br/>'.$e->getMessage().'<br/><br/>'.$stmt->debugDumpParams());
      }
      
    }
    
    //abstract find all
    public static function find_all()
    {
      $sql='select * from '.static::$table_name .' ';     //use the table name for each one class
      $stmt= self::$db->prepare($sql);
      return static::find_by_sql($stmt);
  
    //works , but it will use the function 'find_by_sql()' to execute all find sql statement 
    }

    public static function count_all()
    {
        $sql='select count(*) from '.static::$table_name.';';

        $stmt= self::$db->prepare($sql);

        try
        {    
          self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
          $stmt->execute();
          return  (int)  $stmt->fetchColumn();       //return the number of results 
        }catch(PDOException $e)
        {   
          //works fine, but need to be enabled(1º line on try)
          die("Não foi possível apagar o contato.".'<br/>'.$e->getMessage()); 
        }
    }
  
    public static function find_by_id($id)
    {
      $sql='select * from '.static::$table_name .' ';
      $sql .=' where id= ?';
  
      $stmt= self::$db->prepare($sql);       //bind parameter
      $stmt->bindParam(1,$id);
  
      #return self::find_by_sql($sql);
      $obj_array=static::find_by_sql($stmt);   //save result
  
      if(!empty($obj_array))                 //if result
      {
        return array_shift($obj_array);      //return 1º element
      }else
      {
        return false;
      }
    }
  
    //function to initialize the properties of the object from the values(columns) of the DB record
    protected static function instantiate($record)
    {
      $object= new static;      //need static to be for every class
  
      //could manually assign the values to each property (ex: $object->brand=$record['brand'];)
      //but automatically assignment is easier and re-usable
      foreach($record as $key => $value)
      {
        if(property_exists($object,$key)) //PHP method to check if the property exits inside the object
        {
          $object->$key=$value;         //assign the value from DB column field, to the correspondent property of the object
        }
      }
      return $object;
    }
  
    //validate fields (properties) before any operation. functions used are inside file 'validation_functions.php'
    //this class will be override in all classes to perform custom validations
    protected function validate()
    { 
      $this->errors=[];   //to make sure when start validate it always starts empty . reset the errors
  
      //add custom validation in specific classes

      return $this->errors;
  
    } 
  
    public function create()
    { 
      $this->validate();    //check if there are any errors before isnert into DB
      if(!empty($this->errors)) //check if there are no errors anymore
      {
        return false;
      }
  
      $attributes= $this->attributes();   //function to get list of attributes and values dynamically, less ID

      //temp array to add ':' to each key to use bindValue prepared statement
      $temp=[];
      foreach($attributes as $key => $value)
      {
        $temp[':'.$key]= $value;        //create array with :key => value
      }
  
      $sql='insert into '.static::$table_name .' (';
      $sql .=join(',',array_keys($attributes));   //dinamyc list of db columns, same as properties,
      $sql .=') values(';
      $sql .=join(',',array_keys($temp));
      $sql .=');';

      $stmt= self::$db->prepare($sql);
      
      //abstract bind fill the values with bindvalue
      foreach($attributes as $key => $value)
      {   
          $stmt->bindValue(':'.$key,$this->$key);
          //or
          // $stmt->bindValue(':'.$key,$value);
      }

      try
      {
        self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
        $stmt->execute();
        $this->id=self::$db->lastInsertId();    //return the last inserted ID and put on object id property
        return true;
      }catch(DPOException $e)
      {
        //works fine, but need to be enabled(1º line on try)
        die("Não foi possível criar o contato.".'<br/><br/>'.$e->getMessage().'<br/><br/>'.$stmt->debugDumpParams());
      }
    }
  
    protected function update()
    {
      $this->validate();    //check if there are any errors before isnert into DB
      if(!empty($this->errors)) //check if there are no errors anymore
      {
        return false;
      }
  
      $attributes= $this->attributes();   //function to get list of attributes and values dynamically, less ID
  
      //dynamic set value-pair to update sql syntax
      $attributes_pairs=[];
      foreach($attributes as $key => $value)
      {
        $attributes_pairs[]="{$key}=:{$key}";
      }
  
      $sql='update '.static::$table_name.' set ';
      $sql .= join(', ', $attributes_pairs);
      $sql .= ' where id = :id limit 1;';
  
      //bind parameters to sql prepared statements
      $stmt= self::$db->prepare($sql);  

    //abstract bind fill the values with bindvalue
    foreach($attributes as $key => $value)
    {
        $stmt->bindValue(':'.$key,$this->$key);
        //or
        // $stmt->bindValue(':'.$key,$value);
    }

        $stmt->bindValue(':id',$this->id);      //manual bind only for id since is the last

      try
      {
          self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
          $stmt->execute();
          #$stmt->rowCount() //Returns the number of rows affected by the last SQL statement. not sure if work with prepared statements either
          return true;
      }catch(PDOException $e)
      {   
          //works fine, but need to be enabled(1º line on try)
          die("Não foi possível atualizar o contato.".'<br/><br/>'.$e->getMessage().'<br/><br/>'.$stmt->debugDumpParams());
      }
  
    }
  
    public function delete()
    {
      $sql='delete from '.static::$table_name.' ';       //query
      $sql .=' where id=  ? ';
      $sql .=' limit 1 ;';
      
      //bind parameters to sql prepared statements
      $stmt= self::$db->prepare($sql);
  
      $stmt->bindParam(1,$this->id);
      
      try
      {
  
        self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
        $stmt->execute();
        return true;
      }catch(PDOException $e)
      {   
        //works fine, but need to be enabled(1º line on try)
        die("Não foi possível apagar o contato.".'<br/>'.$e->getMessage()); 
      }
  
      /*
        after deleting, the instance of the object will still exists,
        even thought the database record does not.
        this can be usefil as in:
         $user->first_name . 'was deleted'
        echo 
      */
    }

    public static function count_records()
    {
        $sql='select * from '.static::$table_name.';';

        #$stmt= self::$db->prepare($sql);

        try
        {    
          self::$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);     //enable PDO Exception ERROR 
          $result=self::$db->query($sql);
          return $num_rows=$result->rowCount();         //return the number of results 
        }catch(PDOException $e)
        {   
          //works fine, but need to be enabled(1º line on try)
          die("Não foi possível apagar o contato.".'<br/>'.$e->getMessage()); 
        }
    }
  
    //call create or update, dependig if record exist or not . It will check for the id of the obj to check if exists
    public function save()
    {
      //a new record will not have an ID yet
      if(isset($this->id))
      {
        return $this->update();   //the ID of the object exists, so just update
      }else
      {
        return $this->create(); //the ID of the object don't exist, so create
      }
    }
  
    public function merge_attributes($args=[])
    {
      foreach($args as $key => $value)
      {
        if(property_exists($this,$key) && !is_null($value))   //check if property exists on this instance , on his key, and is not null
        {
          $this->$key = $value;       //foreach instance field , take new value from args
        }
      }
    }
  
    //properties which have db columns , excluding ID that is auto generated on DB
    public function attributes()
    {
      $attributes=[];
      foreach(static::$db_columns as $colum)
      { 
        if($colum == 'id')
        { 
          continue;       //skip the rest of the code and go next
        }
        $attributes[$colum]=$this->$colum;
      }
      return $attributes;
    }

}

/* -------------- END of ACTIVE RECORD CODE DESIGN PATTERN with ABSTRACT -------------- */

?>