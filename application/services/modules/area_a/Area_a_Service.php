<?php
namespace Services\Modules\Area_a;
use Services\GeneralService;
use Libraries\Amazon as Amazon;

class Area_a_Service extends GeneralService
{

    private $us_storage_img_cover;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('storage/img/us_storage_img_cover_model');
        $this->load->model('storage/img/us_storage_img_profile_model');
        $this->load->model('us_usuarios_model');
    }

    public function get_img( $type,$identificador ){
        $data_user      = $this->session->get_userdata();

        $find_usuario   = $this->us_usuarios_model->getWhereMongo(['login' => $data_user['login']]);
        $id = $this->us_usuarios_model->getWhereMongo(['login_atos'=>$identificador],"_id",-1,1,NULL,TRUE);
        foreach( $find_usuario as $get_usuario ):

            switch( $type ){
                case "profile":
                    $path_return = $this->us_storage_img_profile_model->getWhereMongo(['codusuario'=>$get_usuario['_id']],"_id",-1,1,NULL,TRUE);
                    break;
                case "cover":
                    $path_return = $this->us_storage_img_cover_model->getWhereMongo(['codusuario'=>$get_usuario['_id']],"_id",-1,1,NULL,TRUE);

                    break;
                case "where":
                    $path_return = $this->us_storage_img_profile_model->getWhereMongo(['codusuario'=>$id->_id],"_id",-1,1,NULL,TRUE);
                    break;
                case "where_cover":
                    $path_return = $this->us_storage_img_cover_model->getWhereMongo(['codusuario'=>$id->_id],"_id",-1,1,NULL,TRUE);
                    break;
                default:
                    if(empty($type)):
                        GeneralService::Success(['msg'=>'Não foi definido um type valido para retorno!']);
                        exit();
                    endif;
            }

           $path    =  !empty($path_return['server_name'])?$path_return['server_name'] . $path_return['bucket'] . '/' . $path_return['folder_user'] . '/' . $path_return['name_file']:false;

            GeneralService::Success(compact('path'));
        endforeach;
    }
    public function update_img_cover( $data_file ){
        if ( !$data_file ) {
            GeneralService::Error( ['msg' => 'Selecione um a imagem!'] );
        } else {

            if ( $data_file->size > 5242880 ) {
                GeneralService::Error(['msg' => 'Tamanho de arquivo deve ser de no máximo 5MB']);
                exit();
            }
            $bucket_name    = 'atos.click';
            $s3             = new Amazon\S3();
            $hash           = uniqid(rand()) . date("Y-m-d H:i:so");
            $data_user      = $this->session->get_userdata();
            $find_usuario   = $this->mongodb->atos->us_usuarios->find(['login' => $data_user['login']]);

            foreach($find_usuario as $get_usuario){

                $search              = ["(", ")", ".", "-", " ", "X", "*", "!", "@", "'", "´", ",", "+", ":"];
                $name_replace        = str_replace($search, "", $hash);
                $name_file           = $name_replace . md5($get_usuario['login']);
                $data_file['name']   = $name_file;

                $s3->putBucket( $bucket_name );

                $name_folder_user = $get_usuario['nome'] . md5($get_usuario['login'] );

                if ( $s3->putObjectFile($data_file['tmp_name'], $bucket_name, $name_folder_user . '/' . $name_file, Amazon\S3::ACL_PUBLIC_READ ) ) {

                    $us_storage_img = $this->mongodb->atos->us_storage_img_cover;
                    $us_storage_img->insertOne([
                        'server_name'   => 'https://s3.amazonaws.com/',
                        'bucket'        => $bucket_name,
                        'folder_user'   => $name_folder_user,
                        'name_file'     => $name_file,
                        'codusuario'    => $get_usuario['_id'],
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s'),

                    ]);
                    $path = 'https://s3.amazonaws.com/' . $bucket_name . '/' . $name_folder_user . '/' .  $name_file;
                    GeneralService::Success( compact('path') );
                }else{
                    GeneralService::Error( ['msg'=>'Erro ao baixar a imagem para o servidor!'] );
                }
            }
        }
    }


}