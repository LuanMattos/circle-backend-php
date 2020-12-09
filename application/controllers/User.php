<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Modules\Account\RestoreAccount;

class User extends Home_Controller
{

    private $RestoreAccount;

    public function __construct(){
        parent::__construct();
        $this->load->model("user/User_model");
        $this->load->model("follower/Follower_model");
        $this->load->library('email/mail');
    }

    public function login(){
        $data = $this->getDataHeader();
        $pass = false;
        if( $data )
            switch ( $data ){
                case !$data->password:
                    $error = "Password is required!";
                break;
                case !$data->userName:
                    $error = "User name is required!";
                break;
            }

            $user = $this->User_model->getWhere( ['user_name' => $data->userName ],"row" );

//        debug(password_hash( "123",PASSWORD_ARGON2I ));

        !$user ? $error = "Usuário inválido!" : $pass = password_verify( $data->password,$user->user_password );

            !$pass ? $error = "Senha incorreta!" : false;

            if( $error ):
                $this->response( $error,"error" );
            endif;

            $newData = [
                "user_id" => $user->user_id,
                "user_name" => $user->user_name,
                "user_full_name" => $user->user_full_name,
                "user_email" => $user->user_email,
                "description" => $user->description,
                "address"=>$user->address
            ];

        $dados = $this->generateJWT( $newData );
        $this->setHeaders( $dados,'x-access-token' );

        $this->response( $newData );

    }
    public function register(){
        $this->dataUserEmail();
        $data = $this->getDataHeader();
        $user = $this->User_model->userNameExists( $data->userName );

        $user ? $error = "Usuário já cadastrado " : $error = "";

        switch ( $data ):
            case !$data->email || !filter_var( $data->email, FILTER_VALIDATE_EMAIL ):
                $error .= "E-mail inválido";
            case !$data->userName || strlen( $data->userName ) < 3:
                $error .= "Nome de usuário inválido";
            case !$data->fullName:
                $error .= "Nome de usuário inválido";
            case !$data->password || strlen( $data->password ) < 8:
                $error .= "Senha inválida";
        endswitch;

        if( $error ):
            $this->response( $error,'error' );
        endif;
        $user = [
            'user_name'=>$data->userName,
            'user_email'=>$data->email,
            'user_full_name'=>$data->fullName,
            'user_password'=>password_hash( $data->password, PASSWORD_ARGON2I )
        ];

        $userSave = $this->User_model->save( $user, ['user_id','user_name','user_email']);

//        $this->dataUserEmail( $userSave );

    }
    private function dataUserEmail( $user = null){
        $user['user_email'] = 'patrickluan.matos@gmail.com';
        $user['user_name'] = 'teste';
        $codigoVerificacao = 'dsdfd';

//        $code = new RestoreAccount\AccountService( $user );
//        $codigoVerificacao = $code->generateCode();

        $mail  = new Mail();
        $nome                       = ucfirst( $user['user_name'] );
        $param = [];
        $param['from']              = '	account.mycircle.click@mycircle.click';
        $param['to']                = $user['user_email'];
        $param['name']              = "Circle";
        $param['name_to']           = $user['user_name'];
        $param['assunto']           = 'Ativação de conta Circle!';
        $data['codigo_confirmacao'] = $codigoVerificacao;
        $data['cadastro']           = true;
        $data['nome']               = $nome;


        $html = $this->load->view("email/confirme",$data,true);
        $param['corpo']      = '';
        $param['corpo_html'] = $html;
        $send = $mail->send( $param );
        debug($send);
    }
    public function userExists( $_userName = false ){
        $userName = $this->getDataUrl(2);

        $user = $this->User_model->userNameExists($userName);

        if( $user )
            $this->response(true);

    }
    public function search(){
        $data = $this->getDataHeader();
        $offset = $this->getDataUrl( 2);

        if( $data )

        $users =  $this->User_model->searchUser( $data->name,$offset );
        $this->response( $users );
    }
    public function saveSetting(){
        $data = $this->getDataHeader();
        $userHeader = $this->dataUserJwt( 'x-access-token' );

        if( !$data->userEmail || !$data->userPassword ){
            $this->response('Os campos acima devem ser preenchidos!','error');
        }

        $user = $this->User_model->getWhere(['user_name'=>$userHeader->user_name],'row');

        if( !$user ):
            $this->response('Usuário não encontrado!','error');
        endif;

        $pass = $user->user_password;

        if( $data->userPasswordChange ):
            $pass = password_hash( $data->userPasswordChange,PASSWORD_ARGON2I );
        endif;

        $verify = password_verify( $data->userPassword,$user->user_password );

        if( !$verify ):
            $this->response('Senha Incorreta','error');
        endif;


        $newData = [
            'user_id'=>$user->user_id,
            'user_password'=>substr($pass,0,250),
            'user_email'=>substr($data->userEmail,0,250),
            'address'=>substr($data->userAddress,0,400),
            'description'=>addslashes( substr($data->userDescription,0,99) ),
        ];

        $this->User_model->save( $newData );
        $this->response('Salvo com sucesso');
    }
    public function uploadImgProfile(){
        $jwtData = $this->dataUserJwt( 'x-access-token' );

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        if( !$user ):
            $this->response('Usuário não existe!','error');
        endif;

        $nameFolder = $this->CreateFolderIfNotExists( $user->user_id );

        //Download - criar serviço
        $file_name =  md5( date('Y-m-d H:i:s') . uniqid() . $user->user_name) . $_FILES['imageFile']['name'];
        $config = [
            'upload_path' => 'storage/img/' . $nameFolder .'/profile/',
            'allowed_types' => 'gif|jpg|png|jpeg|bmp',
            'file_name' => $file_name
        ];
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('imageFile' ) )
        {
            $result = array('error' => $this->upload->display_errors());
            $this->response($result,"error");

        }else{
            $newData = ["user_avatar_url"=>"https://be.mycircle.click/storage/img/$nameFolder/profile/$file_name"];
            $this->db->update('user',$newData,["user_id" => $user->user_id]);


            $this->response("https://be.mycircle.click/storage/img/$nameFolder/profile/$file_name");
        }

    }
    public function uploadImgCover(){
        $jwtData = $this->dataUserJwt( 'x-access-token' );

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        if( !$user ):
            $this->response('Usuário não existe!','error');
        endif;

        $nameFolder = $this->CreateFolderIfNotExists( $user->user_id );

        //Download - criar serviço
        $file_name =  md5( date('Y-m-d H:i:s') . uniqid() . $user->user_name) . $_FILES['imageFile']['name'];
        $config = [
            'upload_path' => 'storage/img/' . $nameFolder .'/cover/',
            'allowed_types' => 'gif|jpg|png|jpeg|bmp',
            'file_name' => $file_name
        ];
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('imageFile' ) )
        {
            $result = array('error' => $this->upload->display_errors());
            $this->response($result,"error");

        }else{
            $newData = ["user_cover_url"=>"https://be.mycircle.click/storage/img/$nameFolder/cover/$file_name"];
            $this->db->update('user',$newData,["user_id" => $user->user_id]);


            $this->response("https://be.mycircle.click/storage/img/$nameFolder/cover/$file_name");
        }

    }

    /** Criar serviço específico para isso UploadImgProfile **/
    private function CreateFolderIfNotExists( $userId ){
        $user = $this->User_model->getWhere(['user_id'=>$userId],"row");

        if( $user && (!$user->name_folder) ):
            $pathName = md5( $user->user_name . date('Y-m-d H:i:s') );
            $nameFolder = $this->ExecShell( $pathName . "/profile" );
            $this->ExecShell( $pathName . "/cover" );

            $this->db->update('user',['name_folder'=>$nameFolder],['user_id'=>$user->user_id]);
            return $nameFolder;
        endif;

        return $user->name_folder;
    }
    private function ExecShell( $nameFolder ){
        shell_exec('sudo mkdir ' . 'storage/img/' . $nameFolder );
        shell_exec('sudo chmod -R 777 '. 'storage/img/' . $nameFolder );
        return $nameFolder;
    }

    public function dataUserBasic( ){
        $userName = $this->getDataUrl(2);

        $dataJwt = $this->dataUserJwt('x-access-token');

        $user = $this->User_model->getWhere( ["user_name"=>$userName],"row" );

        if( !$user ):
            $this->response('Erro geral, por favor,tente mais tarde!','error');
        endif;

        $data = [
            'user_id'=>$user->user_id,
            'user_avatar_url'=>$user->user_avatar_url,
            'user_cover_url'=>$user->user_cover_url,
            'user_full_name'=>$user->user_full_name,
            'user_email'=>$user->user_email,
            'user_name'=>$user->user_name,
            'address'=>$user->address,
            'description'=>$user->description,
            'following'=>$this->followingOwner( $dataJwt, $user->user_id ),
            'user_followers'=>$user->user_followers,
            'user_following'=>$user->user_following
        ];

        $this->response( $data );

    }
    private function followingOwner( $dataJwt, $userIdUrl ){
        if( $dataJwt ):
            $data = [ 'user_id_from'=>$dataJwt->user_id, 'user_id_to'=>$userIdUrl ];
            return $this->Follower_model->getwhere( $data ) ? true : false;
        endif;
        return false;
    }

}
