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
    public function saveComment(){
        $header = apache_request_headers();

        $uri  = $this->uri->slash_segment(2);
        $id = str_replace(['/','?','´'],'',$uri);

        $data = file_get_contents('php://input');
        $data ? $data = json_decode( $data ) :false;


        $user = file_get_contents('php://input');
        $user ? $user = json_decode( $user ) :false;

        if( $id && $data->commentText )

        /** Validação do comentário (se é detentor da edição) **/
        $jwtData = $this->dataUserJwt( $header['x-access-token'] );

        $userValidComment = $this->User_model->getWhere( ['user_name'=>$jwtData->user_name],"row" );

        if( !$userValidComment ):
            $this->response('Erro geral, tente mais tarde!','error');
         endif;

        if( $userValidComment->user_name !== $user->userName ):
            $this->response('Pratica ilegal ao tentar editar  comentário de outro usuário!','error');
        endif;

        $comment = [
            'comment_id'=>$id,
            'comment_text'=>$data->commentText
        ];
        $data = $this->Comments_model->save( $comment,['comment_id','comment_date','comment_text'] );

        $this->response( $data );
    }
    public function getCommentId(){
        $uri  = $this->uri->slash_segment(2);
        $id = str_replace(['/','?','´'],'',$uri);
        $comment = $this->Comments_model->getWhere(['comment_id'=>$id]);
        $this->response($comment);
    }

}
