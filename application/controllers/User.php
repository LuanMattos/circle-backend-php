<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("user/User_model");
    }

    public function login(){
        $data = file_get_contents('php://input');
        $data ? $data = json_decode( $data ) : false;
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

            !$user ? $error = "Usuário inválido!" : $pass = password_verify( $data->password,$user->user_password );

            !$pass ? $error = "Senha incorreta!" : false;

            if( $error ):
                $this->response( $error,"error" );
            endif;

            $newData = [
                "user_id" => $user->user_id,
                "user_name" => $user->user_name,
                "user_fullName" => $user->user_full_name,
                "user_email" => $user->user_email,
            ];

        $dados = $this->generateJWT( $newData );
        $this->setHeaders( $dados,'x-access-token' );

        $this->response( $newData );

    }
    public function register(){
        $data = file_get_contents('php://input');
        $data ? $data = json_decode( $data ) : false;
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

        if( $error ):
            $this->response( $error,'error' );
        endif;
        $user = [
            'user_name'=>$data->userName,
            'user_email'=>$data->email,
            'user_full_name'=>$data->fullName,
            'user_password'=>password_hash( $data->password,PASSWORD_ARGON2I )
        ];
        $this->User_model->save( $user );

    }
    public function userExists(){
        $uri  = $this->uri->slash_segment(2);
        $userName = str_replace(['/','?','´'],'',$uri);

        $user = $this->User_model->getWhere(['user_name'=>$userName],"row");

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

}
