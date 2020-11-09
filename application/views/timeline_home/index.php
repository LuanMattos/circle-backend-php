<div>
<!--    v-bind:class="display_notification"-->
    <div  v-bind:class="display_notification"   style="z-index: 1000;position:fixed;float:bottom;right:1%;bottom:10%" v-cloak>
        <section @click="close_notify()">
            <div class="tn-box tn-box-color-2">
                <p>
                    {{name_new_message | firstUpperCase}} enviou uma nova mensagem
                    &nbsp; <i class="fas fa-flag-checkered"></i>
                </p>
            </div>
        </section>
    </div>
    <div v-if="posts" v-cloak>
        <div class="col-sm-12" v-for="(post, index) in posts" style="margin-bottom: 30px">
            <div class="main-tabs ">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-upcoming">
                        <div class="main-posts">
                            <div class="event-main-post">
                                <div class="event-top">
                                    <div class="activity-group">
                                        <div class="event-top-left">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <div class="maine-activity-img" >
                                                            <img class='crop-img-home' :src="post.img_profile?post.img_profile:path_img_time_line_default">
                                                        </div>
                                                    </td>
                                                    <td width="400px">
                                                        <a href="#" >
                                                            <span class="name-user-post">{{post.nome}}</span>
                                                            <div class="title-post">{{post.text}}</div>
                                                            <div class="date-post">{{post.created_at}}</div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                       <div class="post-dt-dropdown dropdown">
                                                                <span class="dropdown-toggle-no-caret" role="button"
                                                                      data-toggle="dropdown">
                                                                     <i class="fas fa-ellipsis-v"></i>
                                                                </span>
                                                                <div class="dropdown-menu post-rt-dropdown dropdown-menu-right">
                                                                    <a class="post-link-item" href="#">Ocultar</a>
                                                                    <?php if(!isset($data['externo'])): ?>
                                                                        <template v-if="post.delete">
                                                                            <a class="post-link-item" href="javascript:void(0)"  @click="excluir_postagem(post._id,posts,index)">Excluir</a>
                                                                        </template>
                                                                    <?php endif; ?>
                                                                    <a class="post-link-item" href="#">Detalhes</a>
                                                                    <a class="post-link-item" href="#">Perfil usuário</a>
                                                                    <a class="post-link-item" href="#">Reportar</a>
                                                                </div>
                                                            </div>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="event-main-image">
                                    <div class="main-photo" >
                                        <img class="crop-img-center cursor-pointer" :src="post.path" @click="showImg(post.path)">
                                    </div>
                                </div>
                                <!--<div class="event-city-dt p-2">
                                    <ul class="city-dt-list">
                                        <li>
                                            <div class="it-items">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="list-text-dt">
                                                    <ins>Novo Hamburgo</ins>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="it-items">
                                                <i class="fas fa-calendar-alt"></i>
                                                <div class="list-text-dt">
                                                    <ins>21 Nov 2019</ins>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="it-items">
                                                <i class="fas fa-clock"></i>
                                                <div class="list-text-dt">
                                                    <ins>6 PM</ins>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>-->
                                <div class="like-comments ">
                                    <div class="left-comments">
                                       <a href="javascript:void(0)" class="like-item" title="Curtida" @click="compute_like(post,index)">
                                          <i v-bind:class="action_like  + ' ' + (post.liked ? 'text-like':'')" ></i>
                                          <span>{{post.count_like}}</span>
                                       </a>
<!--                                       <a href="#" class="like-item lc-left" title="Comment">-->
<!--                                            <i class="fas fa-comment-alt"></i>-->
<!--                                            <span> 10</span>-->
<!--                                       </a>-->
                                    </div>
<!--                                    <div class="right-comments">-->
<!--                                        <a href="#" class="like-item" title="Share">-->
<!--                                            <i class="fas fa-share-alt"></i>-->
<!--                                            <span> 21</span>-->
<!--                                        </a>-->
<!--                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-if="loading">
            <div class="scrollpane">
                <ul id="results" />
            </div>
        </template>
    </div>
</div>

