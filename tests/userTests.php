<?php

namespace tests;

#require_once dirname(dirname(__FILE__)) . '/vendor/boot.php';
#require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

use PHPUnit\Framework\TestCase;     //include testcase from PHPUnit

use app\controller\UserController;                    //include correspondent class to test 

use app\DatabaseObject;

include dirname(dirname(__FILE__)) . '/vendor/database.php';

use vendor;

use vendor\template;

//create the class to test
class UserControllerTest extends TestCase          //class to test from Unit
{
    
    public function setUp():void
    {   
        $this->User = new UserController();     //create instance of the class to test
        $this->db   = vendor\db_connect();      //set DB connection
    }
    
    public function tearDown():void
    {
        unset($this->User);
    }

    //function to test db class connection
    /**
    * @dataProvider provideDbArguments
    */
    public function testDbConnection($input)
    {
        

        $output = $this->db;                //method on receipt class
        #var_dump($output);exit();

        //it works
        /*
         $this->assertEquals(
            #new \PDO($input),                //expected value from the result
            new \PDO('mysql:host=10.2.40.94;dbname=teste5;','diogo','teste123'),
            $output,                        //actual value
            "error connecting to DB!"       //message display in case of failure
        ); */

        //also works
        $this->assertIsObject(
            new \PDO('mysql:host=10.2.40.94;dbname=teste5;','diogo','teste123'),
            'error connecting to DB!'
        );

    }

    public function provideDbArguments()
    {   
        //test cases arguments
		return [
            ['mysql:host=', '10.2.40.94'],
			['dbname=', 'teste5'],
            ['diogo'],
            ['teste5']
		];
    }

    //simple test
    /**
    * @runInSeparateProcess
    **/
    public function testLogin()
    {   
        //arguments to test login() method
        $_POST['username'] = 'admin2';
        $_POST['password'] = 'admin2';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        //set db connection before test login, since login use db connection
        $db = DatabaseObject::set_database($this->db);

        //call login method() to test
        $response = $this->User->login();   //the string 'true' is to force the return of true on method to test

        #$response->assertSessionMissing('errors');

        #$this->assertTrue(true);
        
        /*          
            $this->assertContains(
            'Location:/logs', xdebug_get_headers()
        ); */


        $this->assertEquals(
            $response,
            json_encode(['message' => 'Login successfull.']),
            'not possible to login'
        );
    }

    public function testModify()
    {
        //arguments to test login() method
        $_POST['username'] = 'admin2';
        $_POST['password'] = 'admin2';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        //set db connection before test login, since login use db connection
        $db = DatabaseObject::set_database($this->db);

        //call login method() to test
        $response = $this->User->modify();   //the string 'true' is to force the return of true on method to test

        $this->assertEquals(
            $response,
            json_encode(['message' => 'Sucess updating user password!']),
            'not possible to modify the user'
        );
    }

    public function testRegister()
    {
        //arguments to test login() method
        $_POST['username'] = 'admin2';
        $_POST['password'] = 'admin2';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        //set db connection before test login, since login use db connection
        $db = DatabaseObject::set_database($this->db);

        //call login method() to test
        $response = $this->User->Register();   //the string 'true' is to force the return of true on method to test

        $this->assertEquals(
            $response,
            json_encode(['message' => 'Sucess creating new user']),
            'not possible to register the user'
        );

    }


    //simple test
    public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }
    

}

?>