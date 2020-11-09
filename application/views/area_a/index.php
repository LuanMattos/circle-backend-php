<?php if(isset($data['externo'])): ?>
    <div class="dash-todo-thumbnail-area1 " id="content-area-a">
        <div class="dash-todo-thumbnail-area1 crop-img-home dash-bg-image1 dash-bg-overlay cursor-pointer" v-bind:style="img_cover.length?'background-image:url(' + img_cover + ')':'background-image:url('+path_img_cover_default +')' ">
            <div class="float-right mr-4" style="margin-top: 60px">
                <div class="icon-home-cover" >
                    <i class="far fa-eye" @click="showImg(img_cover,'',false)" ></i>
                </div>
            </div>
        </div>
        <div class="dash-todo-header1 cursor-pointer">
            <div class="container ">
                <div class="row ">
                    <div class="col-lg-12 col-md-12 ">
                        <div class="my-profile-dash ">
                            <div class="my-dp-dash ">
                                <div class=" container-avatar">
                                    <div class="overlay-avatar-home" >
                                        <div class="icon-home-profile cursor-pointer" @click="showImg(img_profile,'#input-file-img-profile',false)">

                                            <i class="far fa-eye home-profile"></i>
                                        </div>
                                    </div>
                                    <img class="image_avatar crop-img-home" :src="img_profile.length?img_profile:path_img_profile_default">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="dash-todo-thumbnail-area1 crop-img-home dash-bg-image1 dash-bg-overlay cursor-pointer"  id="content-area-a" v-bind:style="img_cover.length?'background-image:url(' + img_cover + ')':'background-image:url('+path_img_cover_default +')' ">
        <div class="todo-thumb1 dash-bg-image1 dash-bg-overlay" >
            <div class="float-right mr-4" style="margin-top: 60px" >
                <div class="icon-home-cover" >
                        <i class="far fa-eye" @click="showImg(img_cover,'#input-file-img-cover',true)" ></i>
                </div>
            </div>
            <input type="file" id="input-file-img-cover" name="fileimagemcover" style="display:none" @change="update_img_cover">
        </div>
        <div class="dash-todo-header1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="my-profile-dash">
                            <div class="my-dp-dash">
                                <div class=" container-avatar" >
                                    <img :src="img_profile.length?img_profile:path_img_profile_default" class="image_avatar crop-img-home">
                                    <div class="overlay-avatar-home">
                                        <div class="icon-home-profile cursor-pointer">
                                            <i class="far fa-eye home-profile" @click="showImg(img_profile,'#input-file-img-profile',true)" style="font-size:44px"></i>
                                        </div>
                                    </div>
                                    <input type="file" id="input-file-img-profile" name="fileimagemprofile" style="display:none" @change="update_img_profile">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
