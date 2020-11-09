<!DOCTYPE html>
<html lang="pt-br">

<head>
   <?php $this->load->view('head/css') ?>
</head>

<body class="body-bg">
<main class="register-mp tela-confirmacao">
    <div class="main-section">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <div class="login-register-bg">
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="lr-right">
                                    <div class="login-register-form">
                                        <div id="form-tela-confirmacao">
                                            <div class="form-group">
                                                <input class="title-discussion-input"
                                                       type="email"
                                                       placeholder="Confirme seu E-mail"
                                                       name="email"
                                                       autocomplete="off"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <input class="title-discussion-input"
                                                       type="password"
                                                       placeholder="Nova Senha (8 dígitos)"
                                                       name="senha"
                                                       minlength="8"
                                                       autocomplete="off"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <input class="title-discussion-input"
                                                       type="password"
                                                       placeholder="Repita a nova senha"
                                                       name="confirmar_senha"
                                                       minlength="8"
                                                       autocomplete="off"
                                                >
                                            </div>
                                            <button class="login-btn" type="button" @click="salvar()">Salvar</button>
                                        </div>
                                        <template v-if="msg_success">
                                            <div class="success"  style="color:#00abef;font-size:14px">
                                                <template v-for="i in msg_success">
                                                    {{i}}
                                                </template>
                                            </div>
                                        </template>
                                        <template v-if="msg_error">
                                            <div class="success"  style="color:red;font-size:14px">
                                                <template v-for="i in msg_error">
                                                    {{i}}<br>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="background-color: #3a3e3e; ">
                                <div class="text-white" style="text-align: center;margin-top:15%;position: relative;font-size: 100px">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-ui-1.12.1/jquery-ui.js") ?> "></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.nice-select.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/jquery.mask.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/skills-search.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/datepicker.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/i18n/datepicker.en.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/owl.carousel.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/custom1.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/axios.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/underscore.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/vue.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/mascaras.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/i18n/datepicker.pt-BR.js"></script>
<script>
  var vue_instance_confirmation_pass = new Vue({
    el: ".tela-confirmacao",
    data: {
      msg_success:false,
      msg_error:false

    },
    methods: {
      salvar:function(){
        const url = App.url("","confirm_password","","");
        App.spinner_start();

        $.ajax(
            {
                method:"POST",
                dataType:"json",
                url,
                data:{email:$("input[name='email']").val(),senha:$("input[name='senha']").val(),confirmar_senha:$("input[name='confirmar_senha']").val()},
                success:function(json){
                if(json){
                  App.spinner_stop();
                  if(!_.isUndefined(json.msg_success)){
                    vue_instance_confirmation_pass.msg_success = json.msg_success;
                    window.location.href = App.url("","go","");
                  }
                  if(!_.isUndefined(json.msg_error)){
                    vue_instance_confirmation_pass.msg_error = json.msg_error
                }
              }
            }
          }
        )
      }
    }
  }
)

</script>

</body>

</html>