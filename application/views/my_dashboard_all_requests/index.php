<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<?php   if(isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;
?>
<?php $this->load->view("menu/menu",compact("data")) ?>
<main class="dashboard-mp">
    <?php $this->load->view("area_b/index"); ?>
    <?php $this->load->view("area_c_dashboard_all_requests/index"); ?>
</main>
<?php $this->load->view("footer/footer"); ?>
<?php $this->load->view("head/js"); ?>
<script src="<?= URL_RAIZ() ?>js/area_a/area_a.js"></script>

</body>

</html>