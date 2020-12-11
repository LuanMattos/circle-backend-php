<?php

class Deploy extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
            $this->exec();
            echo "Deploy concluído";
    }


    private function exec()
    {
        shell_exec('cd /public_html/circle-backend-php');
        shell_exec('git pull');

        shell_exec('cd /public_html/circle-backend-php && git pull');
    }

}
