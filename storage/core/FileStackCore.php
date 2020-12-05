<?php
require_once 'Loader.php';

class FileStackCore extends Loader
{
    private $accessOriginConfig;

    function __construct()
    {
        parent::__construct();
        $this->accessOriginConfig = Loader::config('access_origin');
        $this->accessControl();
//        debug(getDataJwt('x-access-token'));
    }

    private function accessControl()
    {

        if (strstr($this->origin(), $this->accessOriginConfig['origin'])) {
            foreach ($this->accessOriginConfig['headers'] as $row) {
                header("$row");
            }
        } else {
            http_response_code(404);
            exit();
        }
    }

    private function origin()
    {
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        } else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $origin = $_SERVER['HTTP_REFERER'];
        } else {
            $origin = $_SERVER['REMOTE_ADDR'];
        }
        return $origin;
    }

}