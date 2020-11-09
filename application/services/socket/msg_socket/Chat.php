<?php

namespace Chat;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\Driver\Manager;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

require_once '../../../../application/config/database_chat.php';

class Chat  implements MessageComponentInterface {
    protected $clients;
    private $subscriptions;
    private $users;
    private $config;
    private $mongodb;
    private $mongobulkwrite;
    private $mongomanager;
    private $codusuario;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
        $config         = new \database_chat();
        $this->config   = (object)$config->config_mongo(true);
        $this->mongodb        = new \MongoDB\Client("mongodb://".$this->config->hostname . ":" . $this->config->port,[],[]);
        $this->mongobulkwrite = new \MongoDB\Driver\BulkWrite();
        $this->mongomanager   = new Manager("mongodb://".$this->config->hostname . ":" . $this->config->port,[],[]);

    }


    public function onOpen( ConnectionInterface $conn ) {
        $id_usuario = $conn->httpRequest->getUri()->getQuery();
        $id = $conn->httpRequest->getHeader ('Cookie');

        $usuario     = $this->mongodb->{$this->config->database}->us_usuarios->find(["_id"=>$id_usuario],['limit'=>1])->toArray();
        $msg_usuario = $this->mongodb->{$this->config->database}->msg_usuarios->find(["codusuario"=>$id_usuario],['limit'=>1])->toArray();
        $this->codusuario = $usuario[0]->_id;
        if(!empty( $usuario ) && !empty( $id ) ){

            $data = [
                "codusuario" => $usuario[0]->_id,
                "status"     => 1,
                "token"      => md5($id[0]),
                "resourceId" => $conn->resourceId
            ];

        if(count($msg_usuario)){
            $this->mongocollection("msg_usuarios",[])->updateOne(["_id"=>new \MongoDB\BSON\ObjectId($msg_usuario[0]['_id'])],['$set'=>$data]);
        }else{
            $this->mongodb->{$this->config->database}->msg_usuarios->insertOne( $data );
        }

            $this->users[$conn->resourceId] = $conn;
//          $this->clients->attach( $conn );

            echo "Nova conexão! ({$conn->resourceId})\n";
            echo json_encode($conn->resourceId);

        }

   }
    public function msgToUser($msg, $id) {
        $this->clients[$id]->send($msg);
    }

    public function onMessage( ConnectionInterface $from, $msg ) {

        $data = json_decode($msg);
        $to = $this->mongodb->{$this->config->database}->us_usuarios->find(["login"=>$data->to],['limit'=>1])->toArray();

        //user local
        $from_id = $from->httpRequest->getUri()->getQuery();



        switch ($data->command) {
            case "subscribe":
                $this->subscriptions[$from->resourceId] = $data->channel;
                break;
            case "message":
            if(isset( $this->users[$data->channel] )){
                $this->users[$data->channel]->send($msg);
                $data_msg   = [
                    "msg" => [
                        "_id"         => new ObjectId(),
                        "codusuario"  => new ObjectId($to[0]->_id),
                        "text"        => $data->text,
                        "created_at"  => date('Y-m-d H:i:s'),
                        "recebendo"   => false
                    ]
                ];
                $where  = [ "codusuario" => $from_id ];

                $this->save_sub_document($data_msg, $where, $type = '$addToSet',$table = "msg_usuarios");

//                --------------usuario que está recebendo

                $data_msg   = [
                    "msg" => [
                        "_id"         => new ObjectId(),
                        "codusuario"  => new ObjectId($from_id),
                        "text"        => $data->text,
                        "created_at"  => date('Y-m-d H:i:s'),
                        "recebendo"   => true
                    ]
                ];

                $where  = [ "codusuario" => $to[0]->_id ];
                $this->save_sub_document($data_msg, $where, $type = '$addToSet',$table = "msg_usuarios");
            }

        }
    }

    public function onClose( ConnectionInterface $conn ) {
//        $this->clients->detach( $conn );
//
        echo "Conexão {$conn->resourceId} foi desconectado\n";
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);
    }

    public function onError( ConnectionInterface $conn, \Exception $e ) {
        echo "Um erro ocorreu: {$e->getMessage()}\n";

        $conn->close();
    }
    public function mongocollection($collection,$options){
        return  new Collection($this->mongomanager,$this->config->database,$collection,$options);
    }
    public function save_sub_document($data = [],$where = [], $type = '$addToSet',$table = "msg_usuarios"){
        $configmongo = (object)$this->config;

        $mongobulkwrite         = new \MongoDB\Driver\BulkWrite();;

        $mongobulkwrite->update(
            $where,
            [$type => $data],
            ['upsert' => true]
        );
        $this->mongomanager->executeBulkWrite($configmongo->database . '.' . $table ,$mongobulkwrite);

    }

}

