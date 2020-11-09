<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<?php
if (isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;
?>
<?php $this->load->view("area_a/index"); ?>
<?php $this->load->view("menu/menu", compact("data")); ?>
<?php $this->load->view("area_b/index",compact("data")); ?>
<main class="dashboard-mp" id="div-geral-pessoas-full">
    <main class="Search-results">
        <div class="main-section">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 col-md-12">
                        <div class="search-bar-main">
                            <input type="text" class="search-1" placeholder="Buscar pessoas">
                            <i class="fas fa-search srch-ic"></i>
                        </div>
                    </div>
                </div>
            </div >
            <div class="all-search-events" >
                <div class="container" >
                    <div class="row" v-if="data_users.length > 0">
                        <div class="col-lg-3 col-md-6"  v-for="(i,l) in data_users" v-if="i">
                             <div class="user-data full-width">

                                                <div class="user-profile ">
                                                    <div class="username-dt dpbg-1 ">
                                                        <div class="my-dp-dash crop-img-card-full-pessoas cursor-pointer " v-bind:style="i[0].img_cover.length?'background-image:url(' + i[0].img_cover + ');':''">
                                                            <img class="crop-img-home-mini" :src="i[0].img_profile.length?i[0].img_profile:default_img_profile" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="user-main-details">
                                                        <div class="row ml-3">
                                                            <div class="col-10 text-truncate" v-cloak >
                                                                    {{i[0].nome}}
                                                            </div>
                                                        </div>
                                                        <span v-cloak="">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                             <div class="row ml-3">
                                                                <div class="col-10 text-truncate" v-cloak >
                                                                        {{i[0].endereco}}
                                                                </div>
                                                            </div>
                                                            <div class="row ml-3">
                                                                <div class="col-10 text-truncate" v-cloak >
                                                                        {{i[0].sobrenome}}

                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <ul class="follow-msg-dt">
                                                        <li>
                                                            <div class="msg-dt-sm card-button-pessoa" >
                                                                <div class="amizade-buttom" style="display: none">
                                                                      <button  class=" msg-btn2  " data-toggle="dropdown">Amigos </button>
                                                                      <div class="dropdown-menu">
                                                                            <span class="dropdown-item cursor-pointer" @click="delete_amizade(i[0]._id,l)">Excluir amizade</span>
                                                                       </div>
                                                                </div>
                                                                    <template v-if="i[0].amigo_solicitante">
                                                                        <button  class="msg-btn3 btn-confirmar-amizade" @click="aceitar_pessoa(i[0]._id,l)" data-id-btn="$index">Confirmar </button>
                                                                    </template>
                                                                    <template v-else>
                                                                        <button  class="btn-cancelar-amizade" v-bind:class="i[0].sol?'msg-btn2 ' + ' button-add-person':'msg-btn1 ' + ' button-add-person'" @click="add_person(i[0]._id,l)" data-id-btn="$index">{{i[0].sol?'Cancelar ':'Adicionar'}}</button>
                                                                    </template>
                                                                        <button  class="btn-adicionar-amizade" style="display: none" @click="add_person(i[0]._id,l)" data-id-btn="$index">Adicionar</button>

                                                            </div>
                                                        </li>
                                                        <li>
                                                            <template v-if="i[0].amigo_solicitante">
                                                                <div class="follow-dt-sm">
                                                                    <button class="follow-btn1">Recusar</button>
                                                                </div>
                                                            </template>
                                                            <template v-else>
                                                                <div class="follow-dt-sm">
                                                                    <button class="follow-btn1">Seguir</button>
                                                                </div>
                                                            </template>
                                                        </li>
                                                    </ul>
                                                    <div class="profile-link">
                                                        <a href="javascript:void(0)" @click="redirect_user(i[0]._id)">Perfil</a>
                                                    </div>
                                                </div>
                                    </div>
                        </div>
                        <div class="col-md-12" v-if="loading">
                            <mugen-scroll :handler="getPosts" :should-handle="loading">
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </mugen-scroll>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</main>
<?php $this->load->view("footer/footer"); ?>
<?php $this->load->view("head/js"); ?>
<script src="<?= URL_RAIZ() ?>js/area_a/area_a.js"></script>
<script src="<?= URL_RAIZ() ?>js/pessoas/pessoas.js"></script>

</body>

</html>