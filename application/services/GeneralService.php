<?php
namespace Services;

class GeneralService extends \CI_Model {

    public  function __construct(){
        parent::__construct();
    }
    static public function Success( $data,$type = 'success' )
    {
        header( 'Content-type: application/json' );

        if( $type == 'error' ):
            echo json_encode( $data );
            set_status_header(404);
        endif;
        echo json_encode($data);
        exit();
    }

}
