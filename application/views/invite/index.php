<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<!-- Header Start -->
<?php $this->load->view("menu/menu") ?>
<div class="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ol class="title-bar-text">
                    <li class="breadcrumb-item"><a href="<?= site_url('Home/Logged') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Invite Friends</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Title Bar End -->
<!-- Body Start -->
<main class="discussion-mp">
    <div class="main-section">
        <div class="invite-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="invite-img">
                            <img src="<?= URL_RAIZ() ?>application/assets/libs/images/invite.svg" alt="">
                        </div>
                        <div class="invite-heading">
                            <h3>Convide seus amigos para o atos</h3>
                            <p>Escolha os seus melhores amigos para se inspirar.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-lg-6 col-sm-12">
                        <div class="Share-today">
                            <h4>Basta inserir um telefone celular ou E-mail</h4>
                            <div class="copylink">
                                    <input type="text" class="copy-link-input" placeholder="Número de telefone ou E-mail" name="email_telefone">
                                    <button class="copy-link-btn"><i class="far fa-copy"></i> Enviar</button>
                            </div>
                            <div class="error-success">

                            </div>
                        </div>

                        <div class="Share--links">
                            <div class="social-acc1 text-center">
                                <div class="signup-scl-scc">
                                    <a href="#">
                                        <div class="link-block">
                                            <i class="fab fa-facebook-f facebook"></i>
                                        </div>
                                        <span>Facebook</span>
                                    </a>
                                    <a href="#">
                                        <div class="link-block">
                                            <i class="fab fa-twitter twitter"></i>
                                        </div>
                                        <span>Twitter</span>
                                    </a>
                                    <a href="#">
                                        <div class="link-block">
                                            <i class="fab fa-google google"></i>
                                        </div>
                                        <span>Google</span>
                                    </a>
                                    <a href="#">
                                        <div class="link-block">
                                            <i class="fab fa-linkedin-in linkedin"></i>
                                        </div>
                                        <span>LinkedIn</span>
                                    </a>
                                    <a href="#">
                                        <div class="link-block">
                                            <i class="fab fa-whatsapp whatsapp"></i>
                                        </div>
                                        <span>Whatsapp</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="how-its-work">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="work-heading">
                                <h2>Como funciona</h2>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="works-1">
                                <div class="work-icon">
                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/work-1.svg" alt="">
                                </div>
                                <h4>Número de telefone ou e-mail</h4>
                                <p>Insira o número de telefoe de seu amigo ou o E-mail.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="works-1">
                                <div class="work-icon">
                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/work-2.svg" alt="">
                                </div>
                                <h4>Cadastro do amigo</h4>
                                <p>Seu amigo receberá um link onde efetuará o cadastro!</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="works-1">
                                <div class="work-icon">
                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/work-2.svg" alt="">
                                </div>
                                <h4>Inspire-se</h4>
                                <p>Você e seu amigo já podem se conectar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php $this->load->view("footer/footer"); ?>
<?php $this->load->view("head/js"); ?>


</body>

</html>
<script>
    $(".copy-link-btn").on('click',function(){
      App.spinner_start();
      $.post(App.url('','invitesend',''),{
        email_telefone:$("input[name='email_telefone']").val()
      },function(json){
                    if(json){
                      App.spinner_stop();

                      if(json.error){
                              $(".error-success").text(json.error.msg).css('color','red');

                        }
                            if(json.msg){
                              $(".error-success").text(json.msg).css('color','blue');
                        }
                    }
                },'json'
            )
        }
    )
</script>