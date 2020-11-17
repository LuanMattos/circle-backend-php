<?php

namespace Modules\Storage\Create_folder_user;
use Services;

class Create_folder_user extends Services\GeneralService
{

    private $user;
    private $file;
    private $error;
    private $data;

    public function __construct( $file, $user,$data ){
        parent::__construct();

        $this->load->model("user/User_model");
        $this->load->model("photos/Photos_model");

        $this->user = $user;
        $this->file = $file;
        $this->data = $data;
        $this->UploadFile();
    }

    private function UploadFile(){
        $name = $this->createFolder();
        $file_name =  md5( date('Y-m-d H:i:s') . uniqid()) .  $this->file['imageFile']['name'];
        $config = [
            'upload_path' => 'storage/img/' . $name .'/',
            'allowed_types' => 'gif|jpg|png|jpeg|bmp',
            'file_name' => $file_name
        ];
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('imageFile' ) )
        {
            $this->error = true;
            $result = array('error' => $this->upload->display_errors());
        }
        else
        {
            $data = [
              'user_id'=>$this->user->user_id,
              'photo_post_date'=>date('Y-m-d H:i:s'),
              'photo_url'=>"http://localhost/storage/img/{$name}/{$file_name}",
              'photo_description'=>$this->data->description,
              'photo_allow_comments'=>$this->data->allowComments === 'true'?'1':'0',
              'photo_public'=>$this->data->public === 'true'?'1':'0',
              'photo_likes'=>0,
            ];

            $this->Photos_model->save( $data );
            $result = array('upload_data' => $this->upload->data());
        }
        if( $this->error ):
            self::Success( $result,"error" );
        endif;

        echo json_encode( $result );

    }
    private function createFolder(){

            if( !$this->user->name_folder ||  empty( $this->user->name_folder) ) {

                    $name = $this->create_folder();

                    $data = [
                        "name_folder" => $name,
                        "user_id" => $this->user->user_id
                    ];

                    $this->User_model->save( $data );

            }
            $name =  $this->User_model->getWhere( ['user_id' => $this->user->user_id],"row" );
            return $name->name_folder;
    }

    public function create_folder(){
        $name = md5( $this->user->user_name . date('Y-m-d H:i:s') );
        shell_exec('mkdir ' . 'storage/img/' . $name . '/profile');
        shell_exec('chmod -R 777 '. 'storage/img/' . $name . '/profile');

        return $name;
    }
}
