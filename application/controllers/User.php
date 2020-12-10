<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Modules\Account\RestoreAccount;
use Modules\Storage\Create_folder_user as Upload;

class User extends Home_Controller
{

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
                "address"=>$user->address,
                "user_code_verification"=>$user->user_code_verification ? true : false
            ];

        $dados = $this->generateJWT( $newData );
        $this->setHeaders( $dados,'x-access-token' );

        $this->response( $newData );

    }
    public function register(){
        $data = $this->getDataHeader();
        $error = "";

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

        $user = $this->User_model->userExistsEmail( $data->user_name );
        $userEmail = $this->User_model->userExistsEmail( $data->user_email );

        if( $user || $userEmail ){
            $error = "Usuário já cadastrado ";
        }

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

        if( $userSave )
        $this->sendEmail( $userSave );

    }
    private function sendEmail( $user ){
        $emailFrom = $this->config->item('email_account');

        $code = new RestoreAccount\AccountService();
        $codigoVerificacao = $code->generateCode();

        $code = [
            'user_id' => $user->user_id,
            'user_code_verification' => $code
        ];

        $this->User_model->save( $code );

        $mail  = new Mail();
        $nome                       = $user['user_name'];
        $param = [];
        $param['from']              = $emailFrom;
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
        $mail->send( $param );

    }
    public function userExists(){
        $userName = $this->getDataUrl(2);
        $user = $this->User_model->userExistsUserName($userName);

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

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];

        $dados  = $this->generateJWT( $newData );
        $this->setHeaders( $dados,'x-access-token' );

        new Upload\Create_folder_user( $_FILES, $user,NULL,'avatar' );

    }
    public function uploadImgCover(){
        $jwtData = $this->dataUserJwt( 'x-access-token' );

        $user = $this->User_model->getWhere( ["user_id"=>$jwtData->user_id],"row" );

        $newData = [
            "id" => $user->user_id,
            "name" => $user->user_name,
            "fullName" => $user->user_full_name,
            "email" => $user->user_email,
        ];

        $dados  = $this->generateJWT( $newData );
        $this->setHeaders( $dados,'x-access-token' );

        new Upload\Create_folder_user( $_FILES, $user,NULL,'cover' );

    }

    private function ExecShell( $nameFolder ){
        shell_exec('mkdir ' . 'storage/img/' . $nameFolder );
        shell_exec('chmod -R 777 '. 'storage/img/' . $nameFolder );
        return $nameFolder;
    }

    public function dataUserBasic( ){
        $userName = $this->getDataUrl(2);

        $dataJwt = $this->dataUserJwt('x-access-token');

        $user = $this->User_model->getWhere( ["user_name"=>$userName],"row" );

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

    public function verificationCode(){
        $data = $this->getDataHeader();
        $dataJwt = $this->dataUserJwt('x-access-token');
        $user = $this->User_model->getWhere( ["user_name"=>$dataJwt->user_name, 'user_code_verification'=>$data],"row" );
        $this->db->update('user',['user_code_verification'=>null],["user_id"=>$dataJwt->user_id]);

        if( $user ){
            $newData = [
                "id" => $user->user_id,
                "name" => $user->user_name,
                "fullName" => $user->user_full_name,
                "email" => $user->user_email,
            ];
            $dados  = $this->generateJWT( $newData );
            $this->setHeaders( $dados,'x-access-token' );
        }

    }

}
