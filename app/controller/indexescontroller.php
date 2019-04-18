<?php

namespace app\controller;

class IndexesController
{

    public function test($data = NULL)
    {
        #return "Ola UserId: " .  $data['userId'];

        #$json = json_encode(['nome' => 'diogo','user_id' => '78']);

        $json = json_encode(['nome' => 'diogo','user_id' => $data['user_id'], 'username'=>$data['username']]);

        return $json;
    }

    public static function get_elements_to_drop()
    {   

        $result_set=IndexModel::find_all();

        if(empty($result_set))
        {
            //dropdown empty on 1º time, so go get the values 
        
            //url for request to retrive all values to put inside combobox
            $link = 'https://www.xtb.com/api/uk/instruments/get?queryString=&branchName=uk&instrumentTypeSlug=indices&page=1&_=1550592039763';
            $client = new Client();

            //REST request
            $res = $client->request('GET', $link);

            //REST result body from request
            $result = json_decode((string)$res->getBody());

            //run all indices and put on array
            $all_indexes['value']=[];
            foreach($result->instrumentsCollectionLimited->indices as $indice)
            {
                $all_indexes['symbol']=$indice->symbol;
                $all_indexes['description']=$indice->description;
                $all_indexes['spread_target_standard']=$indice->spread_target_standard;
                $all_indexes['trading_hours']=$indice->trading_hours;
                $all_indexes['type']=$indice->type;

                //create new index
                $index = new IndexModel($all_indexes);

                //insert into DB new index
                $index->save();
            }

            //write on log
            $log_params=[];
            if(isset($_SESSION['username']))
            {
                $log_params['username']=$_SESSION['username'];
            }else
            {
                $log_params['username']='';
            }
            #$log_params['username']=$_SESSION['username'];            
            $log_params['action']='fullfil dropdown ';
            $log_params['time_stamp']=date("Y-m-d H-i-s");
            $log_params['description']='User ' .$_SESSION['username'] .' fullfil all dropbox values from IP: '.$_SERVER['REMOTE_ADDR'];
            
            LogController::write_log($log_params);

        }
    }

}


?>