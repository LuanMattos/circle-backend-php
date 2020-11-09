<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<?php
if(isset($row)):
    $data = $row;
else:
    $data = [];
endif;
?>
<?php $this->load->view("menu/menu",compact("data")); ?>

<main class="dashboard-mp " style="margin-top: 80px" id="div-geral-time-line">

    <div class="main-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="main-left-sidebar">
                        <div class="user-data full-width">
                            <div class="user-profile" >
                                <div class="username-dt dpbg-1">
                                    <div class="my-dp-dash  crop-img-home-mini cursor-pointer" v-bind:style="img_cover.length?'background-image:url(' + img_cover + ')':'background-image:url('+ path_img_cover_default +')'  ">
                                        <img class="crop-img-home" :src="img_profile.length?img_profile:path_img_profile_default" alt="">
                                    </div>
                                </div>
                                <div class="user-main-details">
                                    <h4><?= isset($data['nome'])?ucfirst($data['nome']):""; ?></h4>
                                    <span>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= set_val($data['address']) ?>
                                    </span>
                                </div>
                                <ul class="followers-dts">
                                    <li>
                                        <div class="followers-dt-sm">
                                            <h4>Conexões</h4>
                                            <span><?= $data['count_amigos'] ?></span>
                                        </div>
                                    </li>
<!--                                    <li>-->
<!--                                        <div class="followers-dt-sm">-->
<!--                                            <h4>Seguindo</h4>-->
<!--                                            <span>355</span>-->
<!--                                        </div>-->
<!--                                    </li>-->
                                </ul>
                                <div class="profile-link">
                                    <a href="<?= site_url('mydashboard') ?>">Visualizar perfil</a>
                                </div>
                            </div>
                        </div>
                        <?php $this->load->view("pessoas/menu"); ?>
<!--                        <div class="user-data full-width">-->
<!--                            <div class="categories-left-heading">-->
<!--                                <h3>Categorias</h3>-->
<!--                            </div>-->
<!--                            <div class="categories-items">-->
<!--                                <a class="category-item" href="#"><i class="fas fa-music"></i>Músicas</a>-->
<!--                                <a class="category-item" href="#"><i class="fas fa-flag"></i>Festival</a>-->
<!--                                <a class="category-item" href="#"><i class="fas fa-pen-nib"></i>Arte</a>-->
<!--                                <a class="category-item" href="#"><i class="fas fa-microphone-alt"></i>Clube</a>-->
<!--                                <a class="category-item" href="#"><i class="fas fa-grin-squint-tears"></i>Comedia</a>-->
<!--                                <a class="category-item" href="#"><i class="far fa-futbol"></i>Esportes</a>-->
<!--                                <a class="category-item" href="#"><i class="fas fa-video"></i>Teatro</a>-->
<!--                                <a class="category-item" href="#"><i class="fas fa-bullhorn"></i>Promoções</a>-->
<!--                                <a class="category-item" href="#"><i class="fas fa-ellipsis-h"></i>Outros</a>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>

                <div class="col-lg-6 col-md-7 mt-22">

                    <?php $this->load->view("publicar/index"); ?>

                    <?php $this->load->view("timeline_home/index"); ?>
                </div>

<!--                <div class="col-lg-3 mt-20">-->
<!--                    <div class="right-side-items">-->
<!--                        <div class="post-event">-->
<!--                            <h6>Crie aqui seus eventos</h6>-->
<!--                            <p>Publique aqui seus eventos compartilhando com todos seus amigos.</p>-->
<!--                            <a href="add_new_event.html" class="add-nw-event">Postar</a>-->
<!--                        </div>-->
<!--                        <div class="explore-events">-->
<!--                            <h4>Anúncios</h4>-->
<!--                            <ul class="explore-events-dt">-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="explore-card exp-right light-blue">-->
<!--                                            <div class="explore-item-1">-->
<!--                                                <div class="explore-icon-bg icon-large-1">-->
<!--                                                    <i class="fas fa-sun"></i>-->
<!--                                                </div>-->
<!--                                                <div class="explore-content">-->
<!--                                                    <i class="fas fa-sun"></i>-->
<!--                                                    <span>Today</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="explore-card exp-left light-yellow">-->
<!--                                            <div class="explore-item-1">-->
<!--                                                <div class="explore-icon-bg icon-large-1">-->
<!--                                                    <i class="fas fa-cloud-sun"></i>-->
<!--                                                </div>-->
<!--                                                <div class="explore-content">-->
<!--                                                    <i class="fas fa-cloud-sun"></i>-->
<!--                                                    <span>Tomorrow</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="explore-card exp-right dark-blue">-->
<!--                                            <div class="explore-item-1">-->
<!--                                                <div class="explore-icon-bg icon-large-1">-->
<!--                                                    <i class="fas fa-calendar-alt"></i>-->
<!--                                                </div>-->
<!--                                                <div class="explore-content">-->
<!--                                                    <i class="fas fa-calendar-alt"></i>-->
<!--                                                    <span>This Week</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <div class="explore-card exp-left light-green">-->
<!--                                            <div class="explore-item-1">-->
<!--                                                <div class="explore-icon-bg icon-large-1">-->
<!--                                                    <i class="fas fa-calendar-check"></i>-->
<!--                                                </div>-->
<!--                                                <div class="explore-content">-->
<!--                                                    <i class="fas fa-calendar-check"></i>-->
<!--                                                    <span>Choose Date</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="w-weather">-->
<!--                            <div class="weather-left">-->
<!--                                <div class="weather-city">Ludhiana</div>-->
<!--                                <div class="week-text">Monday</div>-->
<!--                                <div class="week-text">14 Oct 2019</div>-->
<!--                                <div class="week-text" style="font-size: 18px;"><i class="fas fa-tint"></i> 30%</div>-->
<!--                                <ul>-->
<!--                                    <li>-->
<!--                                        <div class="up-down"><i class="fas fa-long-arrow-alt-up"></i> 18°</div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="up-down"><i class="fas fa-long-arrow-alt-down"></i> 25°</div>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                            <div class="weather-right">-->
<!--                                <i class="fas fa-cloud-sun"></i>-->
<!--                                <span>22°</span>-->
<!--                            </div>-->
<!--                            <ul class="weekly-weather">-->
<!--                                <li>-->
<!--                                    <div class="degree-text">32°</div>-->
<!--                                    <div class="weather-icon"><i class="fas fa-sun"></i></div>-->
<!--                                    <div class="day-text">Tue</div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="degree-text">19°</div>-->
<!--                                    <div class="weather-icon"><i class="fas fa-cloud-sun-rain"></i></div>-->
<!--                                    <div class="day-text">Wed</div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="degree-text">32°</div>-->
<!--                                    <div class="weather-icon"><i class="fas fa-cloud-sun"></i></div>-->
<!--                                    <div class="day-text">Thu</div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="degree-text">27°</div>-->
<!--                                    <div class="weather-icon"><i class="fas fa-wind"></i></div>-->
<!--                                    <div class="day-text">Fri</div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="degree-text">22°</div>-->
<!--                                    <div class="weather-icon"><i class="fas fa-cloud-showers-heavy"></i></div>-->
<!--                                    <div class="day-text">Sat</div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="degree-text">12°</div>-->
<!--                                    <div class="weather-icon"><i class="fas fa-snowflake"></i></div>-->
<!--                                    <div class="day-text">Sun</div>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="news-data full-width">-->
<!--                            <div class="categories-left-heading">-->
<!--                                <h3>News</h3>-->
<!--                            </div>-->
<!--                            <div class="categories-items">-->
<!--                                <div class="news-item">-->
<!--                                    <div class="news-item-heading">-->
<!--                                        <i class="fas fa-music"></i>-->
<!--                                        <h6>Music</h6>-->
<!--                                    </div>-->
<!--                                    <div class="news-description">-->
<!--                                        Suspendisse cursus egestas luctus. <a href="#">Http://website.com/news</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="news-item">-->
<!--                                    <div class="news-item-heading">-->
<!--                                        <i class="fas fa-pen-nib"></i>-->
<!--                                        <h6>Art</h6>-->
<!--                                    </div>-->
<!--                                    <div class="news-description">-->
<!--                                        Suspendisse cursus egestas luctus. <a href="#">Http://website.com/news</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="news-item">-->
<!--                                    <div class="news-item-heading">-->
<!--                                        <i class="far fa-futbol"></i>-->
<!--                                        <h6>Sports</h6>-->
<!--                                    </div>-->
<!--                                    <div class="news-description">-->
<!--                                        Suspendisse cursus egestas luctus. <a href="#">Http://website.com/news</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</main>

<?php $this->load->view("template/lightbox_image/index"); ?>

<div id="autocomplete-app"></div>
<?php $this->load->view("footer/footer"); ?>

<div id="content-chat">
    <?php $this->load->view('chat/index'); ?>
</div>
<div class="content-open-menu-chat">
    <i class="fas fa-comments"></i>
</div>
<?php $this->load->view('chat/menu_chat'); ?>
<!-- Scripts js -->
<?php $this->load->view("head/js"); ?>
<?php $this->load->view("head/chat/assets"); ?>
<?php $this->load->view("head/image_lightbox/assets"); ?>

<script src="<?= URL_RAIZ() ?>js/home/home.js"></script>

<?php $this->load->view("head/menu_chat/assets"); ?>
</body>

</html>