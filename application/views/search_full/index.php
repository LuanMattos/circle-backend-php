<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<?php $this->load->view("menu/menu") ?>
<main class="Search-results">
    <div class="main-section">
        <div class="container">
            <div class="row justify-content-md-center" style="margin-top: 5em">
                <div class="col-lg-4 col-md-12">
                    <div class="search-bar-main">
                        <input type="text" class="search-1" placeholder="Buscar">
                        <i class="fas fa-search srch-ic"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="all-search-filters">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-filters">
                            <div class="search-filters-left">
                                <div class="dropdown">
                                    <a href ="#" class="filter-d wt-mp dropdown-toggle-no-caret" role="button" data-toggle="dropdown">Categoria<i class="fas fa-angle-down"></i></a>
                                    <div class="dropdown-menu cate-dropdown">
                                        <a class="link-item" href="">Musica</a>
                                        <a class="link-item" href="#">Vídeos</a>
                                        <a class="link-item" href="#">Fotos</a>
                                        <a class="link-item" href="#">Compartilhamentos</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a href ="" class="filter-d dropdown-toggle-no-caret" role="button" data-toggle="dropdown">Locais<i class="fas fa-angle-down"></i></a>
                                    <div class="dropdown-menu worldwide-dropdown">
                                        <div class="worldwide-form">
                                            <h6>Localização</h6>
                                            <div class="worldwide-inputs">
                                                <form>
                                                    <div class="form-group">
                                                        <label>Região</label>
                                                        <div class="select-bg">
                                                            <select class="wide" style="display: none;">
                                                                <option>Selecione um país*</option>
                                                                <option>India</option>
                                                                <option>USA</option>
                                                                <option>Canada</option>
                                                                <option>Australia</option>
                                                                <option>UK</option>
                                                                <option>Bangladesh</option>
                                                                <option>Nepal</option>
                                                                <option>Pakistan</option>
                                                                <option>Austria</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button class="create-topic mt-4" type="submit">Aplicar</button>
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
        </div>
        <div class="all-search-events">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="event-main-post">
                            <div class="event-top">
                                <div class="event-top-left">
                                    <a href="#">
                                        <h4>Nome de quem postou</h4>
                                    </a>
                                </div>
                                <div class="event-top-right">
                                    <div class="post-dt-dropdown dropdown">
                                        <span class="dropdown-toggle-no-caret" role="button" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></span>
                                        <div class="dropdown-menu post-rt-dropdown dropdown-menu-right">
                                            <a class="post-link-item" href="#">Irrelevante</a>
                                            <a class="post-link-item" href="#">Denunciar</a>
                                            <a class="post-link-item" href="#">Salvar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="event-main-image">
                                <div class="main-photo">
                                    <div class="photo-overlay"></div>
<!--                                    <img src="--><?//= URL_RAIZ() ?><!--application/assets/libs/images/homepage/center/post-img-1.jpg" alt="">-->
                                    <img src="https://abrilexame.files.wordpress.com/2017/02/thinkstockphotos-516262792.jpg?quality=70&strip=info&resize=680,453" alt="">
                                </div>
                            </div>
                            <div class="like-comments">
                                <div class="left-comments">
                                    <a href="#" class="like-item" title="Like">
                                        <i class="fas fa-heart"></i>
                                        <span><ins>Gostar</ins> 251</span>
                                    </a>
                                    <a href="#" class="like-item lc-left" title="Comment">
                                        <i class="fas fa-comment-alt"></i>
                                        <span><ins>Comentar</ins> 10</span>
                                    </a>
                                </div>
                                <div class="right-comments">
                                    <a href="#" class="like-item" title="Share">
                                        <i class="fas fa-share-alt"></i>
                                        <span><ins>Compartilhar</ins> 21</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="main-loader search-loader">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
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
<script src="<?= URL_RAIZ() ?>js/home/home.js"></script>
</body>

</html>