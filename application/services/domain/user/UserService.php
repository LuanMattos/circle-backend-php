<?php
namespace Services\Domain\User\UserService;

use Services\GeneralService;
use Repository\Domain\User;
use Repository\Modules\Log;

class UserService extends GeneralService
{
    private static $userRepository;
    private static $systemDataInformationRepository;

    function __construct(){
        parent::__construct();
        static::$userRepository = new User\UserRepository();
        static::$systemDataInformationRepository = new Log\SystemDataInformationRepository();
    }

    public static function validaDataLogin( $data ){
        $sdi = static::$systemDataInformationRepository->saveDataInformation();

        $error = '';
        switch ( $data ){
            case !$data->password:
                $error = "Password is required!";
                break;
            case !$data->userName:
                $error = "User name is required!";
                break;
        }
        $user = static::$userRepository->getUserByUserName( $data->userName );

        switch ( $user ){
            case !$user:
                $error = "Usuário inválido!";
                static::$systemDataInformationRepository->saveAccessErrorUser( $sdi );
                break;
            case ($user && ($user->user_blocked == 't')):
                $error = "Usuário bloqueado, redefina sua senha!";
                break;
            case !password_verify( $data->password, $user->user_password ):
                $error = "Senha incorreta!";
                static::$systemDataInformationRepository->saveAccessErrorPass( $user );
                break;
        }

        $sdiAuth = (object)static::$systemDataInformationRepository->saveDataInformation( $user );

        static::$systemDataInformationRepository->compareAccessAndNotifyNewDevice( $user, $sdiAuth );

        static::$userRepository->deleteLogUser( $user->user_id );
        static::$userRepository->updateDeviceUser( $sdiAuth->system_data_information_device_id, $user->user_id );

        if( $error ):
            self::Success( $error,"error" );
        endif;
        $user->system_data_information_device_id = 'teste';

        return $user;
    }


}