<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<?php   ;if(isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;

?>
<?php $this->load->view("menu/menu",compact("data","pais_cidade")); ?>


<!-- Header End -->
<!-- Body Start -->
<main class="dashboard-mp">
    <?php $this->load->view("area_b/index",compact("data")); ?>
    <?php $this->load->view("area_c_dashboard_all_notifications/index"); ?>
</main>
<?php $this->load->view("footer/footer"); ?>
<?php $this->load->view("head/js"); ?>
<script src="<?= URL_RAIZ() ?>js/area_a/area_a.js"></script>

</body>

</html>