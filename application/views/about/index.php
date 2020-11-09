<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<!-- Header Start -->
<?php $this->load->view("menu/menu") ?>
<!-- Header End -->
<!-- Title Bar Start -->
<div class="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ol class="title-bar-text">
                    <li class="breadcrumb-item"><a href="<?= site_url("Home/Logged") ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sobre atos</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Title Bar End -->
<!-- Body Start -->
<main class="discussion-mp">
    <div class="main-section">
        <div class="about-us">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="checkout-heading text-center">
                            <h2>Sobre o atos</h2>
                        </div>
                        <div class="about-text">
                            <p>Uma rede que inspira</p>
                            <p>TESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTSTTESTESTESTST.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="about-steps">
                            <div class="about-item1">
                                <div class="about-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <h4>Crie eventos</h4>
                                <p>Crie eventos e convide seus amigos.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="about-steps">
                            <div class="about-item1">
                                <div class="about-icon">
                                    <i class="fas fa-check-square"></i>
                                </div>
                                <h4>Compartilhe sua vida</h4>
                                <p>Compartilhe sua vida e os melhores momentos.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="about-steps">
                            <div class="about-item1">
                                <div class="about-icon">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                                <h4>Conheça</h4>
                                <p>Conheça pessoas sem se importar com a distância.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="about-steps">
                            <div class="about-item1">
                                <div class="about-icon">
                                    <i class="fas fa-smile"></i>
                                </div>
                                <h4>Pura inspiração</h4>
                                <p>Uma rede totalmente moderna que deixa você e seus amigos inspirados.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="about-btn-center">
                            <button class="post-evnt-btn" onclick="window.location.href = 'add_new_event.html';">Poste um evento</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="expert-team">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="team-heading text-center">
                            <h2>Time Expert da atos</h2>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="team-bg">
                            <div class="team-img">
                                <img src="<?= URL_RAIZ() ?>application/assets/libs/images/about/img-1.jpg" alt="">
                                <div class="team-overlay">
                                    <div class="team-overlay-text">
                                        <h4>John Doe</h4>
                                        <span>CEO & Founder</span>
                                        <ul class="experts-social-links">
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="team-bg">
                            <div class="team-img">
                                <img src="<?= URL_RAIZ() ?>application/assets/libs/images/about/img-2.jpg" alt="">
                                <div class="team-overlay">
                                    <div class="team-overlay-text">
                                        <h4>Patrick Luan</h4>
                                        <span>CEO & Fundador</span>
                                        <ul class="experts-social-links">
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="team-bg">
                            <div class="team-img">
                                <img src="<?= URL_RAIZ() ?>application/assets/libs/images/about/img-3.jpg" alt="">
                                <div class="team-overlay">
                                    <div class="team-overlay-text">
                                        <h4>Albert William</h4>
                                        <span>CTO Manager</span>
                                        <ul class="experts-social-links">
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonials">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="testi-heading text-center">
                            <h2>Recado </h2>
                        </div>
                        <div class="owl-testimonials">
                            <div class="owl-carousel testi-owl owl-theme">
                                <div class="item">
                                    <div class="testi-text">
                                        <h6>Inspiração deve existir.</h6>
                                        <p>“ Adoro programar, tudo diversão, nada de trabalho, tudo em livre-arbítrio. ”</p>
                                    </div>
                                    <div class="testi-user-dt">
                                        <h4>Patrick Luan</h4>
                                        <span>Brasil</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="testi-text">
                                        <h6>Teste testste teste teste testste .</h6>
                                        <p>“ Teste testste teste teste testste teste teste testste teste teste testste teste teste testste teste teste teste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste testeteste teste testste teste teste. ”</p>
                                    </div>
                                    <div class="testi-user-dt">
                                        <h4>João</h4>
                                        <span>Teste</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="testi-text">
                                        <h6>Teste testste teste teste.</h6>
                                        <p>“ Teste testste teste teste testste teste teste testste teste teste testste teste teste testste teste teste . ”</p>
                                    </div>
                                    <div class="testi-user-dt">
                                        <h4>Maria</h4>
                                        <span>Teste</span>
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
<?php $this->load->view("footer/footer"); ?>
<?php $this->load->view("head/js"); ?>
</body>

</html>