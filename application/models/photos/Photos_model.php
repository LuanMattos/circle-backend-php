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

    public function getPhotoUser( $userId,$orderby ,$direction ,$limit = 9,$offset ){

        $photos = $this->getWhere([ 'user_id' => $userId ],"array",$orderby ,$direction ,$limit ,$offset);

        if( is_array( $photos ) ){
            foreach ( $photos as $key=>$item ) {
                $photos[$key]['likes'] = $this->Likes_model->getWhere(['photo_id'=>$item['photo_id']],"array",false,null,10);
            }
        }
        return $photos;
    }

}
