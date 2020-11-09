<!DOCTYPE html>
<head>
    <style>
        /*custom font*/
        @import url(https://fonts.googleapis.com/css?family=Montserrat);

        /*basic reset*/
        * {
            margin: 0;
            padding: 0;
        }

        html {
            height: 100%;
            background: #4d4c4c;

        }

        body {
            font-family: montserrat, arial, verdana;
        }

        /*form styles*/
        #msform {
            width: 400px;
            margin: 50px auto;
            text-align: center;
            position: relative;
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 3px;
            box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
            padding: 20px 30px;
            box-sizing: border-box;
            width: 80%;
            margin: 0 10%;

            /*stacking fieldsets above each other*/
            position: relative;
        }

        /*Hide all except first fieldset*/
        /*inputs*/
        #msform input, #msform textarea {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            font-size: 13px;
        }

        /*buttons*/
        #msform .action-button {
            width: 100px;
            background: #4182c4;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 1px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }

        #msform .action-button:hover, #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
        }

        /*headings*/
        .fs-title {
            font-size: 15px;
            text-transform: uppercase;
            color: #2C3E50;
            margin-bottom: 10px;
        }

        .fs-subtitle {
            font-weight: normal;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }

        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
        }

        #progressbar li {
            list-style-type: none;
            color: white;
            text-transform: uppercase;
            font-size: 9px;
            width: 33.33%;
            float: left;
            position: relative;
        }

        #progressbar li:before {
            content: counter(step);
            counter-increment: step;
            width: 20px;
            line-height: 20px;
            display: block;
            font-size: 10px;
            color: #333;
            background: white;
            border-radius: 3px;
            margin: 0 auto 5px auto;
        }

        /*progressbar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: white;
            position: absolute;
            left: -50%;
            top: 9px;
            z-index: -1; /*put it behind the numbers*/
        }

        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none;
        }

        /*marking active/completed steps green*/
        /*The number of the step and the connector before it = green*/
        #progressbar li.active:before, #progressbar li.active:after {
            background: #5d84c4;
            color: white;
        }

        @media screen and (max-width: 992px) {

            #msform fieldset {
                box-sizing: border-box;
                margin: 0;
            }

            #msform {
                width: 100%;
                margin-top: 60px;
                margin-left: 5%;
                text-align: center;
                position: relative;
            }


        }

        .codigo-confirmacao {
            font-size: 50px;
        }

    </style>
</head>
<body>
<form id="msform">
    <?php if(isset($alteracao_email)): ?>
        <fieldset>
            <h2 class="fs-title">Atenção! Recebemos um pedido de alteração E-mail diretamente de sua conta!</h2>
            <h2 class="fs-title">Não divulgue este código com ningúem, guarde-o, ele pode ser solicitado!</h2>
            <h3 class="fs-subtitle">Seu código é <?= set_val( $codigo_confirmacao )  ?></h3>
            <!--		<input type="text" name="fname" placeholder="First Name" />-->
            <!--		<input type="text" name="lname" placeholder="Last Name" />-->
            <!--		<input type="text" name="phone" placeholder="Phone" />-->
            <!--		<textarea name="address" placeholder="Address"></textarea>-->
            <!--            <input type="button" name="previous" class="previous action-button" value="Não fui eu!"/>-->
        </fieldset>
    <?php else: ?>
        <ul id="progressbar" style="<?= isset( $cadastro ) ?'':'display:none' ?>">
            <li class="active">Cadastro</li>
            <li class="active">Verificação</li>
            <li>Configuração</li>
        </ul>

        <fieldset>
            <h2 class="fs-title">Parabéns <?= set_val( $nome ) . " " . set_val( $sobrenome ) ?> estamos quase lá</h2>
            <h3 class="fs-subtitle">Código de confirmação</h3>
            <h3 class="codigo-confirmacao"><?= set_val( $codigo_confirmacao )  ?></h3>
        </fieldset>
        <br>
        <?php if(isset($alteracao_senha)): ?>
            <fieldset>
                <h1 class="fs-title">Atenção! Recebemos um pedido de alteração de senha!</h1>
                <h2 class="fs-title">Seu código de verificação é <?= set_val( $codigo_confirmacao )  ?></h2>
                <h3 class="fs-subtitle">Clique aqui <a href="<?= isset($link)?$link:'' ?>" target="_blank">para redefinir</a></b></h3>
<!--                <a href="--><?//= isset($link_nao_fui_eu)?$link_nao_fui_eu:'' ?><!--" name="previous" class="previous action-button" value="Não fui eu!"/>-->
            </fieldset>
        <?php endif; ?>
    <?php endif; ?>

</form>
</body>
</html>
