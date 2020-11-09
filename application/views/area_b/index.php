<div class="dash-dts">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="event-title">
                    <div class="my-dash-dt">
                        <h3><?= isset($data['nome'])?ucfirst($data['nome']):"" ?></h3>
                        <span><?= isset($data['sobrenome'])?upper_phrase($data['sobrenome']):"" ?></span>
                        <span><i class="fas fa-map-marker-alt"></i>
                            <?= set_val( upper_phrase($data['address'] ) ) ?>
                        </span>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <ul class="right-details">
                    <li>
                        <div class="all-dis-evnt">
                            <div class="dscun-txt">Conexões</div>
                            <div class="dscun-numbr">
                                <?= $data['count_amigos'] ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="my-all-evnts" title="Vocês são amigos">
<!--                            <i class="fas fa-user-check"></i>-->
                        </div>
                    </li>
                    <?php if(isset($data['externo']) && $data['externo']): ?>
                        <!--<li>
                            <div class="content-ico-msg" title="Mandar uma mensagem">
                                <i class="far fa-comments" @click="open_chat(true)"></i>
                            </div>
                        </li>-->
                    <?php else: ?>
                        <!--<li>
                            <div class="content-ico-msg" title="Mandar uma mensagem">
                                <i class="far fa-comments" @click="open_chat()"></i>
                            </div>
                        </li>-->
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        </div>
</div>