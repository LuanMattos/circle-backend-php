<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photos_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->set_table("photo");
        $this->set_table_index("photo_id");
        $this->load->model('likes/Likes_model');
    }

    public function getPhotoUser( $userId,$dataUserLogged, $orderby ,$direction, $limit = 9, $offset ){

        $photos = $this->getWhere([ 'user_id' => $userId ],"array", $orderby, $direction, $limit, $offset );

        if( $dataUserLogged ){
            foreach ( $photos as $key=>$item ) {
                $photos[$key]['likes'] = [];
                $photos[$key]['liked'] = $this->Likes_model->likedMe($item['photo_id'],$dataUserLogged->user_id,"row")?true:false;
                $photos[$key]['user'] = $this->User_model->dataUserPhoto( $dataUserLogged->user_id );
            }
        }
        return $photos;
    }

}
