<!DOCTYPE html>
<html lang="pt-br">

<head>
   <?php $this->load->view('head/css') ?>
</head>

<body class="body-bg">
<main class="register-mp remember-pass">
    <div class="main-section">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <div class="login-register-bg">
                        <div class="row no-gutters">
                            <div class="col-lg-6">
                                <div class="lr-right">
                                    <div class="login-register-form">
                                        <div id="form-remember-pass">
                                            <div class="form-group">
                                                <label>Enviaremos um link para você</label>
                                                <input class="title-discussion-input"
                                                       type="email"
                                                       placeholder="Confirme seu E-mail"
                                                       name="email"
                                                       autocomplete="off"
                                                >
                                            </div>
                                            <button class="login-btn" type="button" @click="enviar()">Enviar</button>
                                        </div>
                                        <div class="error"  style="color:#00abef;font-size:14px">
                                           {{msg}}
                                        </div>
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
  var renew_pass = new Vue({
    el: ".remember-pass",
    data: {
      msg:''
    },
    methods: {
      enviar:function(){
        const url = App.url("","linkrenew","","");
        App.spinner_start();

        $.ajax(
            {
                method:"POST",
                dataType:"json",
                url,
                data:{email:$("input[name='email']").val()},
                success:function(json){
                if(json){
                    renew_pass.msg = json.msg;
                    App.spinner_stop();
                    $(".login-btn").attr('disabled',true)
                    $(".login-btn").css('background-color','grey')
                    setTimeout(function(){
                      window.location.href = App.url("","go","");
                  },'7000'
                )
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