<?php

//namespace vendor;

require 'autoload.php';

use GuzzleHttp\Client;


function call_test()
{
    //the $method will define wich method will be called on .htaccess
    $link = 'http://academiaphpteste5.teste/api/indexes/';   

    $client = new Client();

    $response= $client->request(
        'POST',
        $link,	   //make the call to the URL in the .htaccess file
        [
            'form_params'  =>  [    //use JSON object to sending that since the API use JSON . //its also possible to json_encode the data and send
                'username' => 'ddomingues@growin.pt',
                'password'  =>  '',
                'user_id'    =>  "Diogo-2019",
            ],
        ]
    );

//var_dump($response->getBody());

$var = (string) $response->getBody();

$object= json_decode($var);

$hash = $object->hash;

echo $object->nome . ' userID: ' . $object->user_id . ' username: '. $object->username ."\n";
#    var_dump($var); 

}

function call_register()
{
        //the $method will define wich method will be called on .htaccess
        $link = 'http://academiaphpteste5.teste/api/indexes/register';   

        $client = new Client();

        $response= $client->request(
            'POST',
            $link,	   //make the call to the URL in the .htaccess file
            [
                'form_params'  =>  [    //use JSON object to sending that since the API use JSON . //its also possible to json_encode the data and send
                    'message'    =>  "Diogo-2019",
                ],
            ]
        );

    $var = (string) $response->getBody();

    $object= json_decode($var);

    var_dump($var);

#$hash = $object->hash;

#echo 'Message: '. $object->message . "\n";
}

function call_modify()
{
    //the $method will define wich method will be called on .htaccess
    $link = 'http://academiaphpteste5.teste/api/indexes/alter';   

    $client = new Client();

    $response= $client->request(
        'POST',
        $link,	   //make the call to the URL in the .htaccess file
        [   //use JSON object to sending that since the API use JSON . //its also possible to json_encode the data and send
            'form_params'  =>  [    //pass parameters to inside function
                'hash_code' => '$2y$10$0hCnXYArN9MOg8TX/TRE/.DYGyXd7jNi/9OdDhACJta1PLF5ByLXu',
                'new_pass'=>'admin2',
            ],
        ]
    );

    $object= json_decode((string) $response->getBody());

    var_dump($object);

    #echo "\n". 'Message: '. $object->message . "\n";

}

function call_login()
{
    //the $method will define wich method will be called on .htaccess
    $link = 'http://academiaphpteste5.teste/api/login';   

    $client = new Client();

    $response= $client->request(
        'POST',
        $link,	   //make the call to the URL in the .htaccess file
        [   //use JSON object to sending that since the API use JSON . //its also possible to json_encode the data and send
            'form_params'  =>  [    //pass parameters to inside function
                'username'=>'admin2',
                'password' => 'admin2'
            ],
        ]
    );

    $object= json_decode((string) $response->getBody());

    var_dump($object->message);
    
    return $object->hash;   //to return hash code for the next methods

    #echo "\n". 'Message: '. $object->message . "\n";
}

function call_download($hash)
{
    //the $method will define wich method will be called on .htaccess
    $link = 'http://academiaphpteste5.teste/api/indexes/download';   

    $client = new Client();

    $response= $client->request(
        'POST',
        $link,	   //make the call to the URL in the .htaccess file
        [   //use JSON object to sending that since the API use JSON . //its also possible to json_encode the data and send
            'form_params'  =>  [    //pass parameters to inside function
                'hash_code' => $hash,
            ],
        ]
    );

    $object= json_decode((string) $response->getBody());

    var_dump($object);

    #echo "\n". 'Message: '. $object->message . "\n";

}

#call_test();

#call_register();       //funciona

#call_modify();         //funciona

$hash=call_login();

call_download($hash);

?>