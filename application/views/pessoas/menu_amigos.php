<div class="user-data full-width" >
    <div class="categories-left-heading">
        <h6><a href="<?= site_url("friends")?>">Amigos</a></h6>
    </div>

    <template v-for="i in amigos">
        <div class="sugguest-user">
            <div class="sugguest-user-dt" >
                <a href="javascript:void(0)" @click="redirect_user(i.login_atos)">
                    <img class="crop-img-home-mini" :src="i.img_profile.length?i.img_profile:path_img_time_line_default" alt=""></a>
                <a href="javascript:void(0)" @click="redirect_user(i.login_atos)"><h4>{{i.nome}}</h4></a>
            </div>
            <?php if(set_val($data['externo'])): ?>
            <template v-if="i._id.$oid !== data_user_local._id">
                    <button class="request-btn"><i class="fas fa-user-plus"></i></button>
            </template>
            <?php endif; ?>
        </div>
    </template>
</div>