<?php
namespace Modules\Account\RestoreAccount;

use Services\GeneralService;

class RestoreAccount extends GeneralService {

    /**
     * Gera um codigo para verificacao, verificando se o mesmo já existe
    **/
    public function gerarCodigoValidacao(){
        $code = $this->gerarCodigoVolta();
        if(!$code){
            $codigo = $this->gerarCodigoVolta();
            if(!$codigo){
                return substr(uniqid(),8,14);
            }
            return substr(uniqid(),7,13);
        }

        return $code;

    }
    /**
     * Auxilia a geracao de codigo voltando um valor unico
    **/
    public function gerarCodigoVolta(){
        $uniqueid       = substr(uniqid(),6,12);
        $finally        = $uniqueid;

        $this->load->model("account/Us_usuarios_conta_model");


        $exist = $this->Us_usuarios_conta_model->data_by_code_verification($finally);

        if(!$exist){
            return $finally;
        }
        return false;

    }
    public function generate_link_pass( $hostoff = false ){
        $host = '';
        if( !$hostoff ){
            $host = site_url();
        }
       $uniq =  uniqid();
       $link = $host . 'john34Gsiremailcom' . "/" . $uniq;
       return $link;
    }


}
