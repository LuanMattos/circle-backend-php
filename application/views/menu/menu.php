<header id="content-menu" class="fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-dark1 justify-content-sm-start">
                    <a class="order-1 order-lg-0 ml-lg-0 ml-3 mr-auto " href="index.html">
                        <a class="text-white padding-smal" href="<?= site_url('home') ?>"></a>
                        <button class="navbar-toggler align-self-start" type="button">
                            <i class="fas fa-bars " style="font-size:25px"></i>
                        </button>

                        <div class="collapse navbar-collapse d-flex flex-column flex-lg-row flex-xl-row justify-content-lg-start bg-dark1 p-3 p-lg-0 mt1-5 mt-lg-0 mobileMenu">
                            <div class="open " id="navbarSupportedContent">
                                <a class="text-white hover-default" href="<?= site_url('home') ?>">
                                    <b style="font-size: 25px">atos</b>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-responsive-space"></div>
                            <div style="width: 80%">
                                <script type="text/x-template" id="autocomplete">
                                    <div>
                                        <div class="autocomplete" role="combobox" aria-haspopup="listbox" aria-owns="autocomplete-results" :aria-expanded="isOpen">
                                            <input type="text" placeholder="Buscar"
                                                   class="appearance-none  bg-gray-200 text-gray-700 border border-gray-200 rounded-0 py-1 px-4 input-search-menu"
                                                   @input="onChange"
                                                   v-model="search"
                                                   @keyup.down="onArrowDown"
                                                   @keyup.up="onArrowUp"
                                                   @keyup.enter="onEnter"
                                                   aria-autocomplete="list"
                                                   aria-controls="autocomplete-results"
                                                   :aria-activedescendant="activedescendant"
                                                   :aria-labelledby="ariaLabelledBy"
                                            />
                                        </div>
                                        <ul id="autocomplete-results" v-show="isOpen" class="autocomplete-results" role="listbox" v-bind:class="!results.length?'autocomplete-results-empty-result-class':''">
                                            <li class="loading" v-if="isLoading">
                                                Aguarde...
                                            </li>
                                            <li v-if="!results.length" class="autocomplete-results-empty-register">
                                                Nenhum registro encontrado
                                            </li>
                                            <li v-else v-for="(result, i) in results"
                                                :key="i"
                                                @click="setResult(result)"
                                                class="autocomplete-result"
                                                :class="{ 'is-active': isSelected(i) }"
                                                role="option"
                                                :id="getId(i)"
                                                :aria-selected="isSelected(i)">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="sugguest-user-dt">
                                                            <img class="crop-img-home-mini" :src="result.img_profile.length > 10?result.img_profile:path_img_search_default"  alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <a href="javascript:void(0)" >
                                                            <span class="result-text">{{ result.nome }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>
                                </script>
                                <div id="autocomplete-app">
                                    <div>
                                        <autocomplete :items="itens" aria-labelled-by="fruitLabel" />
                                    </div>
                                </div>
                            </div>
                            <div style="padding-bottom: 30px" class="menu-responsive-top">
                            </div>
                        </div>

                        <ul class="group-icons">
<!--                            <li>-->
<!--                                <a href="--><?//= site_url('Home/search') ?><!--" class="icon-set" title="Explorar">-->
<!--                                    <i class="fab fa-searchengin" style="font-size: 25px"></i>-->
<!--                                </a>-->
<!--                            </li>-->
                            <li class="dropdown">
                                <a href="#" class="icon-set dropdown-toggle-no-caret" role="button"
                                   data-toggle="dropdown"
                                   @click='zerar_notificacoes(amigos)'
                                >
                                    <i class="fas fa-user-plus">
                                    </i>
                                </a>
                                <template v-if="amigos.length">
                                    <span class='count-notify'>{{count_solicitacoes_amizade?count_solicitacoes_amizade:''}}</span>
                                </template>

                                <div class="dropdown-menu user-request-dropdown dropdown-menu-right" >
                                    <template v-if="amigos.length">
                                        <template v-for="(i,l) in amigos">
                                            <div class="user-request-list ">
                                                <div class="request-users card-list-solicitacao">
                                                    <div class="user-request-dt ">
                                                        <a href="javascript:void(0)">
                                                            <img class='crop-img-home-mini' :src="i.img_profile.length?i.img_profile:path_img_time_line_default" alt="">
                                                        </a>
                                                        <a href="javascript:void(0)" class="user-title">{{i.nome}}</a>
                                                    </div>
                                                    <button class="accept-btn" v-on:click.prevent.stop="aceitar_pessoa(i._id,l)">Aceitar</button>
                                                </div>
                                            </div>
                                        </template>
<!--                                        <div class="user-request-list">-->
<!--                                            <a href="--><?//= site_url('my_dashboard_all_requests/My_dashboard_all_requests/index') ?><!--"-->
<!--                                               class="view-all">Visualizar todos convites</a>-->
<!--                                        </div>-->
                                    </template>
                                    <template v-else>

                                        <div class="user-request-list " style="background-color: #dfe8e3">
                                            <div class="request-users card-list-solicitacao">
                                                <div class="user-request-dt " style="font-size: 32px;margin-left:40%">
                                                    <i class="far fa-frown"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="div-sem-solicitacoes">
                                            <a class="content-sem-solicitacoes">Sem solicitações de amizades</a>
                                        </div>
                                    </template>

                                </div>
                            </li>
                            <!--<li class="dropdown">
                                <a href="#" class="icon-set dropdown-toggle-no-caret" role="button"
                                   data-toggle="dropdown">
                                    <i class="fas fa-comment-dots"></i>
                                </a>
                                <div class="dropdown-menu message-dropdown dropdown-menu-right">
                                    <template v-if="msg_menu.length">
                                        <template v-for="msg in msg_menu">
                                            <div class="user-request-list">
                                                <div class="request-users">
                                                    <div class="user-request-dt">
                                                        <a href="#">
                                                            <img v-bind:src="msg.img_profile?msg.img_profile:path_img_time_line_default"
                                                                 class="crop-img-chat">
                                                            <div class="user-title1">{{msg.name}}</div>
                                                            <span>{{msg.text | crop_string}}</span>
                                                        </a>
                                                        <div class="time4">{{msg.dias}}  atrás</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <div class="user-request-list">
                                            <a href="<?/*= site_url('view_full_messages') */?>" class="view-all">Visualizar todas mensagens</a>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="user-request-list " style="background-color: #dfe8e3">
                                            <div class="request-users card-list-solicitacao">
                                                <div class="user-request-dt " style="font-size: 32px;margin-left:40%">
                                                    <i class="far fa-frown"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="div-sem-solicitacoes">
                                            <a class="content-sem-solicitacoes">Sem mensagens</a>
                                        </div>
                                    </template>
                                </div>
                            </li>-->
                            <li class="dropdown">
<!--                                <a href="#" class="icon-set dropdown-toggle-no-caret" role="button" data-toggle="dropdown">-->
<!--                                    <i class="fas fa-bell"></i>-->
<!--                                </a>-->
                                <div class="dropdown-menu notification-dropdown dropdown-menu-right">
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Jassica William</div>
                                                    <span>comment on your video.</span>
                                                </a>
                                            </div>
                                            <div class="time5">2 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Rock Smith</div>
                                                    <span>your order is accepted.</span>
                                                </a>
                                            </div>
                                            <div class="time5">5 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Joy Doe</div>
                                                    <span>your bill slip sent on your email.</span>
                                                </a>
                                            </div>
                                            <div class="time5">10 min ago</div>
                                        </div>
                                    </div>
<!--                                    <div class="user-request-list">-->
<!--                                        <a href="--><?//= site_url('my_dashboard_all_notifications/My_dashboard_all_notifications/index') ?><!--"-->
<!--                                           class="view-all">Visualizar todas notificações</a>-->
<!--                                    </div>-->
                                </div>
                            </li>
                        </ul>
                        <div class="account order-1 dropdown">
                            <a href="#" class="account-link dropdown-toggle-no-caret" role="button" data-toggle="dropdown">
                                <div class="user-dp">
                                    <img class="crop-img-home" :src="img_profile.length?img_profile:path_img_time_line_default" alt=""></div>
                                <span v-cloak>{{data_user_local.nome | firstUpperCase}} </span>
                                <i class="fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu account-dropdown dropdown-menu-right">
                                <a class="link-item" href="<?= site_url('dashboard') ?>">Perfil</a>
                                <a class="link-item" href="<?= site_url('settings') ?>">Configurações da conta</a>
                                <a class="link-item" href="<?= site_url('invite') ?>">Convite</a>
                                <!--<a class="link-item" href="<?/*= site_url('view_full_messages') */?>"><i class="fas fa-tachometer-alt"></i>&nbsp MyDash</a>-->
                                <a class="link-item" href="<?= site_url('close') ?>">Sair</a>
                            </div>
                        </div>
                </nav>
                <div class="overlay"></div>
            </div>
        </div>
    </div>
</header>
