<?php
namespace Modules\Register\RegisterMeService;


use Services\GeneralService;

class RegisterMeService extends GeneralService {

    private $email;

    public function __construct( $email )
    {
        $this->email = $email;
        $this->login_atos();

    }
    private function separate_login(){
        $mail = $this->email;
        if( !$mail ){
            throw new \Exception("Atos: Email is empty!");
        }
        $str = explode("@", $mail);

        if( !count( $str ) ){
            throw new \Exception("Atos: Error separating email string");
        }

        return $str[0];
    }

    public function login_atos(){
        $login = $this->separate_login();

        $validateOne = $this->Us_usuarios_model->getWhereMongo(['login_atos'=>$login],"_id",-1,NULL,NULL);
        $usuario     = $this->Us_usuarios_model->getWhereMongo(['email'=>$this->email],"_id",-1,NULL,NULL,TRUE);

        $data_conta  = [];
        $data_conta["_id"]        = $usuario->_id;
        $data_conta["login_atos"] = $login;

        if( !$usuario ){
            throw new \Exception( "Atos: Problem to save new account, user not fould!" );
        }

        if( $validateOne ){
            $next = count( $validateOne ) + 1;
            $login_atos = $login . $next;

            $Revalidate = $this->Us_usuarios_model->getWhereMongo( ['login_atos' => $login_atos],"_id", -1 , NULL , NULL , FALSE );

            if( $Revalidate ){
                $next = count( $Revalidate ) + (int)$next;
                $login_atos = $login . $next;
            }

            $data_conta["login_atos"] = $login_atos;

        }

        $this->Us_usuarios_model->save_mongo( $data_conta );

    }


}
