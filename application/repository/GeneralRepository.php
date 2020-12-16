<?php
namespace Repository;
require_once('tools/firebase/php-jwt/vendor/autoload.php');
class GeneralRepository extends \CI_Model {

    public  function __construct(){
        parent::__construct();
    }
    static public function Success( $data,$type = 'success' )
    {
        header( 'Content-type: application/json' );

        if( $type == 'error' ):
            echo json_encode( $data, JSON_UNESCAPED_UNICODE );
            set_status_header(404);
        endif;
        echo json_encode($data, JSON_UNESCAPED_UNICODE );
        exit();
    }

    static public function setHeaders( $data ,$name ){
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, $name");
        header("Access-Control-Expose-Headers: $name");
        header("$name: $data");
    }

}
