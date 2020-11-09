var pessoas = {
    Url: function (metodo, params) {
        return App.url("pessoas", "Pessoas", metodo, params);
    }

}

var vue_instance_pessoas = new Vue({
    el:"#div-geral-pessoas-full",
    data:{
        data_users         : [],
        loading            : true,
        class_button       : "msg-btn1",
        content_button     : "",
        default_img_profile : location.origin  + '/application/assets/libs/images/find-peoples/user-1.jpg',

    },
    methods:{
        getPosts() {
                var offset       = this.data_users.length;
                var limit        = 10;
                var vue_self     = this;


            $.post(
                    "dfu",
                    {
                        limit   : limit,
                        offset  : offset
                    },
                    function(json){

                        if(!json.data.all_users.length){
                            vue_self.loading = false;
                        }else{
                               vue_self.data_users.push(json.data.all_users);
                        }
            },'json')

        },
        add_person:function(id,l){
            $.post(
                "add",
                {
                    id:id
                },
                function(json){
                    if(json === "delete"){
                        $(".button-add-person:eq("+ l +")").addClass("msg-btn1");
                        $(".button-add-person:eq("+ l + ")").removeClass("msg-btn2");
                        $(".button-add-person:eq("+ l + ")").removeClass("msg-btn3");
                        $(".button-add-person:eq("+ l +")").html("");
                        $(".button-add-person:eq("+ l +")").html("Adicionar");

                    }
                    if(json === "add"){
                        $(".button-add-person:eq("+ l +")").addClass("msg-btn2");
                        $(".button-add-person:eq("+ l +")").removeClass("msg-btn1");
                        $(".button-add-person:eq("+ l +")").removeClass("msg-btn3");
                        $(".button-add-person:eq("+ l +")").html("");
                        $(".button-add-person:eq("+ l +")").html("Cancelar");

                    }

                },'json')

        },delete_amizade:function(id,l){
            $.post(
                "da",
                {
                    id:id
                },
                function(json){
                    if(json.info){
                        $(".amizade-buttom:eq(" + l + ")").hide();
                        $(".btn-adicionar-amizade:eq(" + l + ")").show();
                        $(".btn-adicionar-amizade:eq("+ l +")").addClass("msg-btn1");
                        $(".btn-adicionar-amizade:eq("+ l + ")").removeClass("msg-btn2");
                        $(".btn-adicionar-amizade:eq("+ l + ")").removeClass("msg-btn3");
                        $(".btn-adicionar-amizade:eq("+ l +")").html("Adicionar");
                    }


                },'json')

        },
        aceitar_pessoa:function(id,l){
            $.post(
                "accept",
                {
                    id:id
                },
                function(json){
                    if(json.info){
                        $(".card-button-pessoa:eq(" + l + ")").find(".btn-confirmar-amizade").hide();
                        $(".card-button-pessoa:eq(" + l + ")").find(".amizade-buttom").show();

                    }

                },'json')
        },
        redirect_user:function (id) {
            var url = "dashboard";
            $.post(
                url,
                {
                    id:id
                },
                function(json){
                    window.location.href = App.url("","external","" + id);
                },'json')

        }

    },

});


$.post(
    "dfu",
    {
        offset:0
    },
    function(json){
        if(typeof json.data.all_users != "undefined"){
            if(json.data.all_users.length){
                vue_instance_pessoas.$data.data_users.push(json.data.all_users);
            }

        }


    },'json')

