<?php

class Loader{

    function __construct(){
    }
    public static function config( $name ){
        include "./config/{$name}.php";
        return $config;
    }

}