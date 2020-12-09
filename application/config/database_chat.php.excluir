<?php
class database_chat  {


    public function config_mongo($shell = false){
        $hostname = "172.20.0.2";

        if($shell){
            $hostname = "localhost";
        }else{
            if(ENVIRONMENT === 'production'){
                $hostname = '172.20.0.2';
            }else{
                $hostname = 'mongo';
            }
        }



//        172.18.0.2

        return  [
            'hostname'      => 'www.atos.click',
            'port'          => '27017',
            'username'      => 'atos',
            'password'      => 'atos',
            'database'      => 'atos'
        ];
    }
}
