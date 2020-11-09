<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body class="body-bg">
<!-- Body Start -->
<main class="register-mp">
    <div class="main-section">
        <div class="container" >
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="login-register-bg">
                        <div class="row no-gutters">
                            <div class="col-lg-6" style="background-color: #3a3e3e">
                                <div class="lg-left">
                                    <div class="lg-logo">
<!--                                        logo pequeno-->
                                    </div>
                                    <div class="lr-text">
                                        <h2>Registrar agora</h2>
                                        <p>Aqui você inspira, aqui você descobre.</p>
                                    </div>
                                </div>
                            </div id="register-index">
                            <div class="col-lg-6" >
                                <div class="lr-right " id="login-register-index-container" >
                                    <h4>Primeiros passos</h4>
                                    <div class="login-register-form">
                                        <form action="<?= site_url('Home/acao_cadastro') ?>" method="POST">
                                            <div class="form-group">
                                                <input class="title-discussion-input" type="text" placeholder="Nome" name="nome"  autocomplete="off" v-model="form.nome">
                                            </div>
                                            <div class="text-left" style="color:red;font-size:12px;font-family: Roboto;" v-cloak>
                                                {{error.nome}}
                                            </div>
                                            <div class="form-group">
                                                <input class="title-discussion-input" type="text" placeholder="Sobrenome" name="sobrenome"  autocomplete="off" v-model="form.sobrenome">
                                            </div>
                                            <div class="text-left" style="color:red;font-size:12px;font-family: Roboto;" v-cloak>
                                                {{error.sobrenome}}
                                            </div>
                                            <div class="form-group">
                                                <input class="title-discussion-input" type="email" placeholder="E-mail" name="email"  autocomplete="off" v-model="form.email">
                                            </div>
                                            <div class="text-left" style="color:red;font-size:12px;font-family: Roboto;" v-cloak>
                                                {{error.email}}
                                                {{error.erro_envio_email}}
                                            </div>
<!--                                            <div class="form-group">-->
<!--                                                <input class="date title-discussion-input  datepicker-here " type="text" placeholder="Data de nascimento"  data-language="pt-BR" name="datanasc" autocomplete="off" >-->
<!--                                            </div>-->
                                            <div class="text-left" style="color:red;font-size:12px;font-family: Roboto;" v-cloak>
                                                {{error.datanasc}}
                                            </div>
                                            <div class="form-group hide" >
                                                <select name="telcodpais" >
                                                    <option value="55">Brasil (55)</option>
                                                </select>
                                            </div>
                                            <div class="form-group" >
                                                <input class="title-discussion-input phone_br"  type="text" placeholder="Tel. Cel. Apenas telefone BR (55)" name="telcel" autocomplete="off" >
                                            </div>
                                            <div class="text-left" style="color:red;font-size:12px;font-family: Roboto;" v-cloak>
                                                {{error.telcel}}
                                            </div>
                                            <div class="form-group">
                                                <input class="title-discussion-input" type="password" placeholder="Senha" name="senhacadastro" autocomplete="off" v-model="form.senhacadastro">
                                            </div>
                                            <div class="text-left" style="color:red;font-size:12px;font-family: Roboto;" v-cloak>
                                                {{error.senhacadastro}}
                                            </div>
                                            <div class="form-group">
                                                <input class="title-discussion-input" type="password" placeholder="Rep. Senha" name="repsenha" autocomplete="off" v-model="form.repsenha">
                                            </div>
                                            <div class="text-left" style="color:red;font-size:12px;font-family: Roboto;" v-cloak>
                                                {{error.repsenha}}
                                            </div>
                                            <div class="rgstr-dt-txt">
                                                Antes de concluir o cadastro leia os <a href="#">Termos</a>, <a href="#">a politica de dados</a> e a <a href="#">política de Cookies</a>. Quando você confirmar o cadastro, receberá um sms/email para confirmação de conta.
                                            </div>
                                            <button class="login-btn" type="submit">Registrar agora</button>
                                            <div class="login-link">Já possui conta? <a href="<?= site_url('go') ?>">Logar Agora</a></div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('head/register/js') ?>
<script src="<?= URL_RAIZ() ?>js/index.js"></script>

</body>

</html>