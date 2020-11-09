<?php
namespace ServiceSms;
use ServiceZenvia;
use Services;

class ServiceSms extends  Services\GeneralService {

    protected   $provider;
    protected   $urlApi = 'https://api-rest.zenvia.com/services/send-sms-multiple';
    public      $error;
    private     $provedor;

    public function __construct(){
        $this->setProvider();
        $this->provider;

    }
    /**
     * Add SMS na fila
     * $param   codigo  msg  destinatario  date_to_send  date_send  created_at  response
     */
    public function addToRow(Array $param = []){
        $this->load->model("sms/Sms_fila_model");
        $sms_fila_model = $this->Sms_fila_model;

        if(empty($param)){
            $this->error = ["msg"=>"Nenhum parâmetro enviado em add To row"];
            exit();
        }
        $sms_fila_model->save($param);
    }
    /**
     * Processa todas as filas de sms
    */
    public function processesRow(){
        $this->load->model("sms/Sms_fila_model");
        $sms_fila_model = $this->Sms_fila_model;
        $get_msg        = $sms_fila_model->getWhere(["date_send"=>null,"date_to_send <= "=>date("Y-m-d H:i:s")]);

        if(empty($this->provider['alias']) || empty($this->provider['password'])){
            $this->error = ['msg'=>"Provedor de SMS não configurado corretamente!"];
            exit();
        }
        if(is_array($get_msg)){
            foreach($get_msg as $row){
                $this->provedor->startFacade($this->provider,$row);
            }
        }

    }
    public function validaTelefoneBr($tel){
        $search = ["(",")",".","-"," ","X","*","!","@","'","´",",","+"];

        $numer  = str_replace($search,"",$tel);

        if(strlen($numer) != 13){
            $this->error = ["msg"=>"Verifique o tamanho do número de telefone"];
            return false;
            exit();
        }
        return $numer;
    }
    /**
     * Processa Linha antes de inserir no banco
     * $param   codigo  msg  destinatario  date_to_send  date_send  created_at  response
     */
    public function processesDirect($param){
        $this->load->model("sms/Sms_fila_model");

            if(empty($this->provider['alias']) || empty($this->provider['password'])){
                $this->error = ['msg'=>"Provedor de SMS não configurado corretamente!"];
                exit();
            }
            $param      = (object)$param;
            $response   = $this->provedor->startFacade($this->provider,$param,TRUE);

            if($response){
                $param              = (array)$param;
                $param["date_send"] = date("Y-m-d H:i:s");
                $this->Sms_fila_model->save($param);
            }
    }
    /**
     * Seta o provedor configurado no banco
     */
    public function setProvider(String $provider_name = NULL){
        $this->load->model("sms/Provider_sms_model");
        if(empty($provider_name) || is_null($provider_name)){
            $provedor = "zenvia";
        }else{
            $provedor = $provider_name;
        }
        switch ($provedor){
            case "zenvia":
                $this->provedor = new ServiceZenvia\ServiceZenvia();
                break;
        }

        $Provider_sms_model = $this->Provider_sms_model;
        $provider           = $this->db->select("*")->from("provider_sms");
        if($provider->get()) {
            $provedorN = $provider->get()->result_array();
            if (count($provedorN)) {
                $provedorN = (object)reset($provedorN);
            }
            $configs = array(
                'alias' => $provedorN->conta,
                'password' => $provedorN->senha,
                'webServiceUrl' => $this->urlApi
            );

            $this->provider = $configs;
        }
    }


}
