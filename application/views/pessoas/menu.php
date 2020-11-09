<div class="user-data full-width" >
    <div class="categories-left-heading">
        <h6>Sugestões</h6>
    </div>
    <template v-for="(i,l) in users_menu">
        <div class="sugguest-user">
            <div class="sugguest-user-dt">
                <span class="cursor-pointer" @click="redirect_user(i._id)">
                    <img class="crop-img-home-mini" :src="i.img_profile.length > 10?i.img_profile:path_img_time_line_default" alt="">
                </span>
                <a href="javascript:void(0)" @click="redirect_user(i._id)"><h4>{{i.nome}}</h4></a>
            </div>
            <button  :class="i.sol?'hide':''" class="request-btn btn-enviar-solicitacao" @click="add_person(i._id,l); "><i class="fas fa-user-plus" ></i></button>
            <div  :class="!i.sol?'hide':''  " class="dropdown div-confirmada-solicitacao">
                  <button class="dropdown-toggle request-confirme-btn  " id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-check"></i></button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <span class="dropdown-item cursor-pointer " @click="add_person(i._id,l);" >Cancelar solicitação</span>
                        <span class="dropdown-item cursor-pointer" >Enviar mensagem</span>
                        <span class="dropdown-item cursor-pointer" >Bloquear</span>
                  </div>
            </div>

        </div>
    </template>
</div>