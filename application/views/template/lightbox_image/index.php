<style>
    .fa-edit{
        padding: 25px;
        color:#a8afac;
        font-size: 32px;
        cursor: pointer;
        transition: .5s;
        -webkit-transition: .5s;
        -moz-transition: .5s;
    }
    .fa-edit:hover{
        color:white;
    }

</style>
<div id="lightbox">
    <vue-easy-lightbox
        :visible="visible"
        :imgs="imgs"
        @hide="handleHide"
    >
    <template v-if="edit" v-slot:toolbar="{ toolbarMethods }">
        <div class="menu-image">
             <i class="fas fa-edit " @click="openfile()"></i>
        </div>
    </template>
    </vue-easy-lightbox>
</div>