<head>
    <script type="text/javascript" src="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/js/jquery-3.3.1.slim.min.js") ?>"></script>
    <script type="text/javascript" src="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/dist/js/bootstrap.js") ?>"></script>
    <link rel="stylesheet" href="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/dist/css/bootstrap.css") ?>">
    <link rel="stylesheet" href="<?= site_url("application/assets/js/libs/icons/fontawesome-free-5.10.2-web/css/all.css") ?>">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/style.css" rel="stylesheet">



</head>
<style>
    .bg {
        background-color: #3e3e3f !important;
    }

    [v-cloak] {
        display: none;
    }
    .login-btn:hover{
        background-color: #3e6b9d;
        transition: 1s;
    }
    .description-validate{
        font-size: 14px;
        color:#e5ecea;
    }
    .text-error{
        color:#f4742f;
    }

</style>

<body class="bg">
<div id="general-verification-container">
    <div class="col">
        <div class="img-home">
            <img src="<?= URL_RAIZ() . 'application/assets/images/svg/home.svg' ?>" style="width: 30%">
        </div>
    </div>
        <p class="text-left container text-center description-validate">
            Para prosseguir, precisamos validar sua conta, preencha com o código de
            verificação que você recebeu em seu e-mail e/ou telefone
        </p>
    <div class="row d-flex  justify-content-center p-48">
        <div class="col-md-6 p-48">
            <div class="form-group ">
                <input type="text"
                       class="title-discussion-input"
                       placeholder="Código de verificação"
                       style="height:60px"
                       v-model="form.codevalidation"
                       required
                >
            </div>
        </div>
    </div>
    <div class="row d-flex  justify-content-center">
        <div class="col-md-6">
                <button class="login-btn cursor-pointer"
                        type="button"
                        id="comecar"
                >
                    Enviar
                </button>
                <br>
                <span class='text-error' v-cloak>{{form.error.codigov}}</span>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="<?= site_url("js/verification/verification.js") ?>"></script>
<!-----------------------------------------jquery-default-sistema------------------------------------------------------>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-3.4.1/jquery.js") ?>"></script>
<!------------------------------------------jquery-ui-p/-modal--------------------------------------------------------->
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-1.12.4/jquery-1.12.4.js") ?>"></script>
<!----------------------------------------------jquery-ui-------------------------------------------------------------->
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-ui-1.12.1/jquery-ui.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/vue.js") ?>"></script>
<script type="text/javascript" src="<?= site_url("application/assets/js.js") ?>"></script>
<script type="text/javascript" src="<?= site_url("application/assets/mascaras.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery.mask.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/icons/fontawesome-free-5.10.2-web/js/all.js") ?> "></script>
