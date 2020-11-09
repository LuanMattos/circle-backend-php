<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6bqIsYACsiTkx2B2-8dDaKcuvq3ArXC4&libraries=places"></script>



<body>

<?php $this->load->view("menu/menu", compact("data")) ?>
<!-- Header End -->
<!-- Body Start -->
<main class="dashboard-mp" style="margin-top: 80px;" id="main-config-account-settings">
    <div class="dash-tab-links">
        <div class="container">
            <div class="setting-page mb-20">
                <div class="row">
                    <?php $this->load->view("menu_config/index"); ?>
                    <!--                    #div-geral-config-informacoes-pessoais-index-->
                    <?php $this->load->view("config_informacoes_pessoais/index",compact("data","location")); ?>
                    <!--                    #div-geral-config-perfil-index-->
                    <?php $this->load->view("config_perfil/index",compact("data")); ?>
                    <!--                    #div-geral-config-requisicoes-amizades-->
<!--                    --><?php //$this->load->view("config_requisicoes_amizades/index",compact("data")); ?>
                    <!--                    #div-geral-config-redes-sociais-->
<!--                    --><?php //$this->load->view("config_redes_sociais/index",compact("data")); ?>
                    <!--                    #div-geral-config-email-->
                    <?php $this->load->view("config_email/index",compact("data")); ?>
                    <!--                    #div-geral-config-notificacoes-->
<!--                    --><?php //$this->load->view("config_notificacoes/index",compact("data")); ?>
                    <!--                    #div-geral-config-mudar-senha-->
                    <?php $this->load->view("config_mudar_senha/index",compact("data")); ?>
                    <!--                    #div-geral-desativar-conta-->
                    <?php $this->load->view("config_desativar_conta/index",compact("data")); ?>
                </div>
            </div>
        </div>
    </div>

</main>

<?php $this->load->view("footer/footer"); ?>
<!--JS-->
<?php $this->load->view("head/js"); ?>
<script src="<?= URL_RAIZ() ?>js/config/config.js"></script>
<script src="<?= URL_RAIZ() ?>js/maps/maps_google_account_settings.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/jquery.mask.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/mascaras.js"></script>
</body>

</html>