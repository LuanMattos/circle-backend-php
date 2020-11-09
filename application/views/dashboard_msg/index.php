<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php $this->load->view('head/css') ?>
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/modules/msg_usuarios/dashboard/style.scss" rel="stylesheet">
    <style>
        /*por algum motivo essa merda nao funcionou no style.scsscscsccsscs*/
        .c-bubble-align-left {
            align-self: flex-end;
            display: flex;
            align-items: center;
        }

        .c-bubble-align-left p {
            background-color: #dadcdc;
            border: none;
            order: 1;
        }

        .c-bubble-align-left img {
            order: 2;
            margin-right: 10px;
            margin-left: 10px;
        }
    </style>
</head>

<body>

<?php if (isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;
?>
<div v-bind:class="display_notification" style="z-index: 1000;position:fixed;float:bottom;right:1%;bottom:10%" v-cloak>
    <section @click="close_notify()">
        <div class="tn-box tn-box-color-2">
            <p>
                {{name_new_message | firstUpperCase}} enviou uma nova mensagem
                &nbsp; <i class="fas fa-flag-checkered"></i>
            </p>
        </div>
    </section>
</div>
<main class="dashboard-mp" id="content-chat">
    <?php $this->load->view("menu/menu", compact("data")); ?>
    <div class="div-geral-dashboard">
        <div class='c-app'>
            <aside class='c-sidepanel'>
                <nav class='c-sidepanel__nav'>
                    <ul>
                        <li class='c-sidepanel__nav__li'>
                            <a class='c-sidepanel__nav__link' href='javascript:void(0)' title='' @click="inbox()">
                                <i data-feather="inbox"></i>Inbox
                                <span class='c-notification c-notification--nav'>
                                    {{data_all_messages.length}}
                                </span>
                            </a>
                        </li>
                        <li class='c-sidepanel__nav__li'>
                            <a class='c-sidepanel__nav__link' href='javascript:void(0)' title='' @click="anotacoes()">
                                <i data-feather="edit"></i>Anotações
                            </a>
                        </li>
                        <!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link' href='' title=''><i data-feather="send"></i>Enviados</a></li>-->
                        <!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link' href='' title=''><i data-feather="star"></i>Favourites</a></li>-->
                    </ul>
                </nav>

                <!--                <nav class='c-sidepanel__nav c-sidepanel__nav--spacer'>-->
                <!--                    <ul>-->
                <!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link c-sidepanel__nav__link--success' href='' title=''><i data-feather="check-circle"></i>Paid</a></li>-->
                <!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link c-sidepanel__nav__link--pending' href='' title=''><i data-feather="clock"></i>Pending</a></li>-->
                <!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link c-sidepanel__nav__link--warning' href='' title=''><i data-feather="trash"></i>Denied</a></li>-->
                <!--                    </ul>-->
                <!--                </nav>-->

                <nav class='c-sidepanel__nav c-sidepanel__nav--spacer c-friends'>
                    <!--                    <div class='c-sidepanel__header'>-->
                    <!--                        <h2>-->
                    <!--                            Conversas-->
                    <!--                            <span>-->
                    <!--                                <ul>-->
                    <!--                                    <template v-for="(i,l) in messages">-->
                    <!--                                        <li class='c-friends__list'>-->
                    <!--                                            <a class='c-friends__link' href='javascript:void(0)' @click="open_chat(i)">-->
                    <!--                                                <img class='c-friends__image' :src='i.img_profile.length > 10?i.img_profile:path_img_profile_default'>-->
                    <!--                                                <span class='c-friends__active'>-->
                    <!--                                                    {{i.nome | firstUpperCase}}-->
                    <!--                                                </span>-->
                    <!--                                            </a>-->
                    <!--                                        </li>-->
                    <!--                                    </template>-->
                    <!--                                </ul>-->
                    <!--                            </span>-->
                    <!--                        </h2>-->
                    <!--                        <button>See All</button>-->
                    <!--                    </div>-->
                </nav>
            </aside>
            <div class='c-chats inbox'>
                <div class='c-chats__header'>
                    <div>
                        <label aria-label=''>
                            <i data-feather='search'></i>
                        </label>
                        <input type='text' placeholder='Buscar'>
                    </div>
                </div>
                <ul>
                    <template v-for="(i,l) in data_all_messages">
                        <li class="c-chats__list">
                            <a class="c-chats__link" href="javascript:void(0)" @click="open_chat(i)">
                                <div class="c-chats__image-container">
                                    <img :src='i.img_profile.length > 10?i.img_profile:path_img_profile_default' class="crop-img-home">
                                </div>
                                <div class="c-chats__info">
                                    <p class="c-chats__title">{{i.nome | firstUpperCase}}</p>
                                    <span>{{i.sobrenome | firstUpperCase}}</span>
                                    <!--                                    <p class="c-chats__excerpt"></p>-->
                                </div>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
            <div class='c-openchat inbox'>
                <div class='c-openchat__box messages-content'>
                    <div class='c-openchat__box__header'>
                        <p class='c-openchat__box__name'>{{data_user.nome | firstUpperCase }} {{data_user.sobrenome |
                            firstUpperCase}}</p>
                        <span class='c-openchat__box__status'></span>
                    </div>
                    <div class='c-openchat__box__info'>
                        <ul>
                            <template v-if="!data_user">
                                <div class="empty-chat">
                                    Nenhuma conversa selecionada
                                </div>
                            </template>
                            <template v-else>
                                <template v-for="(i,l) in messages">
                                <li :class="i.recebendo?'c-bubble':'c-bubble-align-left'">
                                    <template v-if="i.recebendo">
                                        <img class='c-bubble__image crop-img-home'
                                             :src='i.img_profile.length > 10?i.img_profile:path_img_profile_default'
                                             alt=''>
                                    </template>
                                    <p class='c-bubble__msg'>
                                        {{i.text}}
                                        <span class='c-bubble__timestamp'>
                                            {{i.created_at}}
                                        </span>
                                    </p>
                                </li>
                            </template>
                            </template>
                        </ul>
                    </div>
                </div>
                <template v-if="data_user">
                    <div class="container-input" style="bottom:8px">
                    <div class="right-input">
                        <div class="write-input">
                            <a href="javascript:;" class="write-link attach"></a>
                            <input type="text" v-model="text" @keyup.enter="sendMessage"/>
                            <div class="container-icon">
                                <i class="fas fa-paper-plane" @click="sendMessage"></i>
                            </div>
                            <a href="javascript:;" class="write-link smiley"></a>
                            <a href="javascript:;" class="write-link send"></a>
                        </div>
                    </div>
                </div>
                </template>
            </div>
            <div class='c-openchat anotacoes hide cards-content'>
                <div class="row-card row-card-first">
                    <template v-for="i in data_anotacoes">
                        <div class="column-card">
                            <div class="card-anotacao">
                                <h6>{{i.title | crop_string(10)}}
                                    <i class="fas fa-trash cursor-pointer" @click="delete_cart(i._id)"></i>
                                    <i class="fas fa-edit cursor-pointer" @click="edit_cart(l)"></i>
                                    <i class="fas fa-check cursor-pointer" @click="confirm_edit(i._id)"></i>
                                </h6>
                                <p class="content-find">{{i.text}}</p>
                                <textarea class="replt-comnt  area-content-edit hide">{{i.text}}</textarea>
                            </div>
                        </div>
                    </template>
                    <div class="column-card card-add">
                        <div class="card-anotacao">
                            <h6>
                                <input type="text" placeholder="Título" class="title-discussion-input title-add">
                            </h6>
                            <textarea class="replt-comnt area-content-add"></textarea>
                            <i class="fas fa-plus cursor-pointer" @click="add_item()" style="font-size:24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>


<?php $this->load->view("footer/footer"); ?>
<!-- Scripts js -->
<?php $this->load->view("head/js"); ?>
<?= $this->load->view('head/dashboard_msg/js'); ?>

</body>
</html>
