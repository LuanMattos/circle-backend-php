<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileUpload extends SI_Controller{

    public function __construct(){
        parent::__construct();
    }

    function file_upload_to_s3(){

        $this->load->library('S3'); //load S3 library
        $this->load->model('Common_mdl'); //load model

        $upload_folder   = 'brand_logo';  //folder name
        $fileTempName    =  '/var/www/html/fileuploadproject/uploads/email_logo.png'; //local image path (who we have to upload on s3)
        $image_name      =  'email_logo.png'; //image name
        $bucket_name     =  'Upload'; //Bucket name
        $awsstatus       =  $this->Common_mdl->amazons3Upload($image_name, $fileTempName, $upload_folder); //call model function
        $awss3filepath   =  "http://".$bucket_name.'.'."s3.amazonaws.com/".$upload_folder.'/'.$image_name;
    }


}
