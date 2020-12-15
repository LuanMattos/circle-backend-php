<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Services\Modules\Auth;
use Services\Cor;

class Comments extends Home_Controller
{
    private $jwt;
    private $http;

    public function __construct(){
        parent::__construct();
        $this->load->model("comments/Comments_model");
        $this->load->model("photos/Photos_model");
        $this->load->model("user/User_model");

        $this->jwt = new Auth\Jwt();
        $this->http = new Cor\Http();
    }

    public function index(){
        $uri  = $this->uri->slash_segment(2);
        $offset  = $this->uri->slash_segment(3);
        $off = $offset?$offset:0;
        $data = str_replace(['/','?','´'],'',$uri);

        $comments = $this->Comments_model->getCommentsByPhoto( $data,3,$off );


//        $this->jwt->encode($newData );
//

        $this->response( $comments );

    }
    public function save(){
        $photoId = $this->http->getDataUrl(2);
        $commentHeader = $this->http::getDataHeader();

        if( !$commentHeader ):
            $this->response('Erro interno, tente mais tarde','error');
        endif;

        $userHeader = $this->jwt->decode();

        $user = $this->User_model->getWhere(['user_name'=>$userHeader->user_name],'row');
        $countComment = $this->Comments_model->getWhere(['photo_id'=>$photoId]);

        $data = [
            'photo_id'=>$photoId,
            'comment_text'=>$commentHeader->commentText,
            'comment_date'=>date('Y-m-d H:i:s'),
            'user_id'=>$user->user_id,

        ];

        //Editar (Impede que usuárioi salve em outro comentário, mesmo se tentar a sorte, vai apenas adicionar um novo para ele mesmo)
        if( $commentHeader->commentId ){
            $validComment = $this->Comments_model->validateCommentEdit( $commentHeader->commentId,$userHeader->user_name );

            if( !$validComment ):
                //salvar ip do usuário
                $this->response('Erro geral, tente mais tarde, ou não.','error');
            endif;

            $data['comment_id']=$commentHeader->commentId;
        }

        $this->Photos_model->save(['photo_id'=>$photoId,'photo_comments'=>count($countComment)]);

        $save = $this->Comments_model->save( $data,['comment_id','comment_date','comment_text','photo_id'] );

        $this->response( $save );

    }

    public function delete(){
        $commentId = $this->http->getDataUrl(2);

        $userHeader = $this->jwt->decode();

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
        $id = $this->http->getDataUrl(2);
        $comment = $this->Comments_model->getWhere(['comment_id'=>$id]);
        $this->response($comment);
    }

}
