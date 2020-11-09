<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends Home_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model("comments/Comments_model");
        $this->load->model("photos/Photos_model");
        $this->load->model("user/User_model");
    }

    public function index(){
        $uri  = $this->uri->slash_segment(2);
        $offset  = $this->uri->slash_segment(3);
        $off = $offset?$offset:0;
        $data = str_replace(['/','?','´'],'',$uri);

        $comments = $this->Comments_model->getCommentsByPhoto( $data,3,$off );


//        $dados  = $this->generateJWT( $newData );
//        $this->setHeaders( $dados,'x-access-token' );

        $this->response( $comments );

    }
    public function save(){
        $uri  = $this->uri->slash_segment(2);
        $id = str_replace(['/','?','´'],'',$uri);

        $data = file_get_contents('php://input');
        $data ? $data = json_decode( $data ) : $this->response('Um comentário de ver inserido','error');
        $comments = $data->commentText;

        $user = $this->User_model->getWhere( ['user_name'=>$data->userName],"row" );

        if( !$user ){
            $this->response('Usuário não encontrado','error');
        }
        $allow = $this->Photos_model->getWhere(['photo_id'=>$id],'row');

        if( $allow->photo_allow_comments == '1' )

        $data = $this->Comments_model->save(
            [
                'comment_date' => date('Y-m-d H:i:s'),
                'comment_text' => $comments,
                'photo_id' => $id,
                'user_id' => $user->user_id
            ],
            "*"
        );

        $user = $this->User_model->getWhere(['user_id'=>$user->user_id],"row");
        $data['user_name'] = $user->user_full_name;

        $this->response( [ $data ] );

    }

}
