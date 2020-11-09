<style id="dynamic-styles"></style>
<div id="hangout" class="content-menu-chat hide-transition">
    <div id="content">
        <div class="list-account">
            <div class="meta-bar">
                <input class="nostyle search-filter" type="text" placeholder="Buscar"/>
            </div>
            <ul class="list mat-ripple">
                <template v-for="amigo in amigos">
                    <li @click="open_chat(amigo)">
                        <img v-bind:src="amigo.img_profile.length > 4?amigo.img_profile:path_img_profile_default" class="crop-img-home-mini">
                        <span class="name">{{amigo.nome | firstUpperCase}} {{amigo.sobrenome | firstUpperCase}}</span><i class="mdi mdi-menu-down"></i>
                    </li>
                </template>
            </ul>
            <div class="bottom-menu">
                <i class="fas fa-angle-double-right" @click="close_menu_chat()"></i>
            </div>
        </div>
    </div>
</div>


