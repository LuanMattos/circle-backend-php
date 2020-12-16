<?php
namespace Modules\Account\RestoreAccount;

use Repository\GeneralRepository;

class AccountService extends GeneralRepository  {

    public function generateCode(){
        $code = substr( uniqid(),6,10);

        return $code;
    }

    public function generateCodeLink( $user ){

        $itemHas[0] = function( $value ){
            return md5(sha1($value->user_id) . md5(uniqid() . time())) . md5( sha1(md5( $value->user_name . uniqid() . time()) ) ) . sha1( md5( $value->user_name . uniqid() ) );
        };
        $itemHas[1] = function( $value ){
            return md5(sha1($value->user_id) . time() . uniqid()) . time();
        };
        $itemHas[3] = function( $value ){
            return md5($value->user_name . sha1(md5($value->user_name. uniqid()) ));
        };
        $itemHas[4] = function( $value ){
            return md5(sha1(md5($value->user_id . md5(time())) . sha1(md5($value->user_password) . md5(time()))));
        };
        $itemHas[5] = function( $value ){
            return md5(md5($value->user_name) . sha1(time() . md5($value->user_name) . time()));
        };
        $itemHas[6] = function( $value ){
            return md5($value->user_name . $value->user_password . sha1($value->user_id . rand(454478,5454545)));
        };
        $itemHas[7] = function( $value ){
            return md5($value . uniqid() . substr($value->user_email,0,strlen($value->user_email) - rand(0,strlen($value->user_email))));
        };

        $code =  substr(md5( $user->user_name . time() ) . md5( $user->user_id ) . md5( $user->user_password ) .  $itemHas[rand(0,7)]($user),0,498);

        return $code;
    }

}