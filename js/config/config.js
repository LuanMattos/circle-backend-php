var config = {
    Url: function (metodo, params) {
        return App.url("account_settings/", "Account_settings", metodo, params);
    }
};

$(function () {


    var pais_option =  $("#selec-pais option:selected").val();
    if(pais_option === ""){
        $("#telcel").attr("disabled",true);
    }else{
        $("#telcel").attr("disabled",false);
    }

    var vue_instance = new Vue({
        el: "#main-config-account-settings",
        data: {
            informacoes_pessoais: {
                data_cidade: "",
                error:false,
                success:""
            },
            requisicoes_amizade:'',
            success_save:"",
            email_conta:'',
            nova_senha:''
        },
        methods: {
            acao_salvar_perfil:function(){
                const url = config.Url("acao_salvar_perfil");
                const data = App.form_data("#form-geral-config-perfil");
                App.spinner_start();

                $.ajax({
                      method:"POST",
                      dataType:"json",
                      url,
                      data:data,
                      success:function(json){
                          if(json.msg){
                              vue_instance.success_save = json.msg;
                              App.spinner_stop();
                          }
                      }
                  }
                );
            },
            acao_salvar_informacoes_pessoais:function(){
                const url = config.Url("acao_salvar_informacoes_pessoais");
                const data = App.form_data("#form-informacoes-pessoais");
                App.spinner_start();

                $.ajax({
                    method:"POST",
                    dataType:"json",
                    url,
                    data:data,
                    success:function(json){
                        App.spinner_stop();
                        if(!json.info){
                            vue_instance.informacoes_pessoais.error = json
                                }
                        if(json.msg){
                            vue_instance.informacoes_pessoais.success = json.msg
                                }
                            }
                        }
                    );
        },
        acao_salvar_solicitacoes_amizades:function(){
            const url = config.Url("acao_salvar_requisicoes_amizade");
            const data = App.form_data("#form-geral-config-requisicoes-amizade");
            App.spinner_start();

            $.ajax({
                  method:"POST",
                  dataType:"json",
                  url,
                  data:data,
                  success:function(json){
                      App.spinner_stop();
                      if(!json.info){
                          vue_instance.requisicoes_amizade.error = json
                      }
                      if(json.msg){
                          vue_instance.requisicoes_amizade.success = json.msg
                      }
                  }
               }
            )
        },
        acao_salvar_email_conta:function(){
                const url = config.Url("acao_salvar_email_conta");
                const data = App.form_data("#form-geral-config-email-conta");
                App.spinner_start();

                $.ajax({
                      method:"POST",
                      dataType:"json",
                      url,
                      data:data,
                      success:function(json){
                          App.spinner_stop();
                          if(json){
                              vue_instance.email_conta = json
                          }
                      }
                  }
                )
            },
        acao_salvar_nova_senha:function(){
            const url = config.Url("acao_salvar_nova_senha");
            const data = App.form_data("#form-mudar-senha");
            App.spinner_start();

            $.ajax({
                method:"POST",
                dataType:"json",
                url,
                data:data,
                success:function(json){
                  App.spinner_stop();
                  if(json){
                    vue_instance.nova_senha = json
                  }
                }
              }
            )
          },

        MenuconfigClick: function (id) {
                $(".config-itens").slideUp();

                this.informacoes_pessoais.error = "";
                this.informacoes_pessoais.success = "";

                switch (id) {
                    case 1:

                        $("#div-geral-config-informacoes-pessoais-index").slideDown();
                        break;
                    case 2:
                        $("#div-geral-config-perfil-index").slideDown();
                        break;
                    case 3:
                        $("#div-geral-config-requisicoes-amizades").slideDown();
                        break;
                    case 4:
                        $("#div-geral-config-redes-sociais").slideDown();
                        break;
                    case 5:
                        $("#div-geral-config-email").slideDown();
                        break;
                    case 6:
                        $("#div-geral-config-notificacoes").slideDown();
                        break;
                    case 7:
                        $("#div-geral-mudar-senha").slideDown();
                        break;
                    case 8:
                        $("#div-geral-desativar-conta").slideDown();
                        break;
                }
            },
        }
    });
})
