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
        $photoId = $this->getDataUrl( 2);
        $commentHeader = $this->getDataHeader();

        if( !$commentHeader ):
            $this->response('Erro interno, tente mais tarde','error');
        endif;

        $userHeader = $this->dataUserJwt( 'x-access-token' );

        $user = $this->User_model->getWhere(['user_name'=>$userHeader->user_name],'row');


        $data = [
            'photo_id'=>$photoId,
            'comment_text'=>$commentHeader->commentText,
            'comment_date'=>date('Y-m-d H:i:s'),
            'user_id'=>$user->user_id
        ];

        //Editar (Impede que usuárioi salve em outro comentári, mesmo se tentar a sorte, vai apenas adicionar um novo para ele mesmo)
        if( $commentHeader->commentId ){
            $validComment = $this->Comments_model->validateCommentEdit( $commentHeader->commentId,$userHeader->user_name );

            if( !$validComment ):
                //salvar ip do usuário
                $this->response('Erro geral, tente mais tarde, ou não.','error');
            endif;

            $data['comment_id']=$commentHeader->commentId;
        }

        $save = $this->Comments_model->save( $data,['comment_id','comment_date','comment_text','photo_id'] );

        $this->response( $save );

    }

    public function delete(){
        $commentId = $this->getDataUrl( 2);

        $userHeader = $this->dataUserJwt( 'x-access-token' );

        if( !$userHeader ):
            $this->response('Erro interno, tente mais tarde','error');
        endif;

        $validComment = $this->Comments_model->validateCommentEdit( $commentId,$userHeader->user_name );

        if( !$validComment ):
            $this->response('Erro interno, tente mais tarde','error');
        endif;

        $delete = $this->Comments_model->deletewhere(['comment_id'=>$commentId]);

        $this->response( $delete );
    }

    public function getCommentId(){
        $uri  = $this->uri->slash_segment(2);
        $id = str_replace(['/','?','´'],'',$uri);
        $comment = $this->Comments_model->getWhere(['comment_id'=>$id]);
        $this->response($comment);
    }

}
