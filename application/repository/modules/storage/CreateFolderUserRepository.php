<?php

namespace Modules\Storage\CreateFolderUserRepository;
use Repository;

class CreateFolderUserRepository extends Repository\GeneralRepository
{
    private $user;
    private $file;
    private $error;
    private $data;
    private $apiDev = "http://localhost/";
    private $apiProd = "https://be.mycircle.click/";
    private $nameFolder;
    private $fileName;
    private $type;
    private $storagePath = 'storage/img/';

    public function __construct( $file, $user,$data = NULL, $type = 'photo'){
        parent::__construct();

        $this->load->model("user/User_model");
        $this->load->model("photos/Photos_model");

        $this->user = $user;
        $this->file = $file;
        $this->data = $data;
        $this->type = $type;

        $this->start();
    }

    private function start(){
        $this->createFolder();
        $fileName = $this->clearNameFolder( $this->file['imageFile']['name'] );
        $this->fileName =  md5( date('Y-m-d H:i:s') . uniqid()) . $fileName;
        $config = [
            'upload_path' => $this->storagePath . $this->nameFolder .'/',
            'allowed_types' => 'gif|jpg|png|jpeg|bmp',
            'file_name' => $this->fileName
        ];
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('imageFile' ) )
        {
            $this->error = true;
            $result = array('error' => $this->upload->display_errors());
        }
        else
        {
            $this->dataSave();
            $upload = (object)$this->upload->data();
            $result = $this->urlApi() . $this->storagePath . $this->nameFolder . '/' . $upload->file_name;
        }

        if( $this->error ):
            $this->revertNameFolder();
            self::Success( $result,"error" );
        endif;

        self::Success( $result );

    }

    private function dataSave(){
        if( $this->type === 'photo' && $this->data ):

            $data = [
                'user_id' => $this->user->user_id,
                'photo_post_date' => date('Y-m-d H:i:s'),
                'photo_url' => $this->urlApi() . "$this->storagePath{$this->nameFolder}/{$this->fileName}",
                'photo_description' => $this->data->description,
                'photo_allow_comments' => $this->data->allowComments === 'false'?'0':'1',
                'photo_public' => $this->data->public === 'true'?'1':'0',
                'photo_likes' => 0,
            ];
            $this->Photos_model->save( $data );

        elseif ( $this->type === 'cover' ||  $this->type === 'avatar'):
            $data = [
                'user_id'=>$this->user->user_id,
                'user_' . $this->type . '_url' => $this->urlApi() . "$this->storagePath{$this->nameFolder}/{$this->fileName}",
            ];
            $this->User_model->save( $data );

        else:
            self::Success('Error on upload type','error');
        endif;

    }

    private function urlApi(){
         return ENVIRONMENT === 'production' ? $this->apiProd : $this->apiDev;
    }

    private function revertNameFolder(){
        if( !$this->user->user_id ){
            self::Success( "Failure revert","error" );
        }
        $revert = [
            'user_id'=>$this->user->user_id,
            'name_folder'=>null
        ];
        $this->db->trans_start();
            $this->User_model->save( $revert );
        $this->db->trans_complete();
    }

    private function createFolder(){

            if( !$this->user->name_folder ||  empty( $this->user->name_folder) ) {

                    $name = $this->ExeShell();

                    $data = [
                        "name_folder" => $name,
                        "user_id" => $this->user->user_id
                    ];

                    $this->User_model->save( $data );

            }
            $name =  $this->User_model->getWhere( ['user_id' => $this->user->user_id],"row" );
            $this->nameFolder =  $name->name_folder;
    }

    private function ExeShell(){
        $name = md5( $this->user->user_name . date('Y-m-d H.i.s') );
        shell_exec('mkdir ' . $this->storagePath . $name );
        shell_exec('mkdir ' . $this->storagePath . $name . '/profile');
        shell_exec('mkdir ' . $this->storagePath . $name );
        shell_exec('mkdir ' . $this->storagePath . $name . '/cover' );
        shell_exec('chmod -R 777 '. $this->storagePath . $name . '/profile');
        shell_exec('chmod -R 777 '. $this->storagePath . $name . '/cover');

        return $name;
    }
    private function clearNameFolder( $fileName ){
        $clear = addslashes( $fileName );
        $newValue = str_replace([' ','/','\/'],'', $clear);
        return $newValue;
    }
}
