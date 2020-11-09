var amigos = {
    Url: function (metodo, params) {
        return App.url("pessoas", "Amigos", metodo, params);
    }

}
var vue_instance_amigos = new Vue({
    el:"#div-geral-amigos-full",
    data:{
        data_amigos        : [],
        loading            : true,
        class_button       : "msg-btn1",
        content_button     : "",
        default_img_profile : location.origin  + '/application/assets/libs/images/find-peoples/user-1.jpg'

    },
    methods:{
        getPosts() {
                var offset       = this.data_amigos.length;
                var limit        = 10;
                var vue_self     = this;


            $.post(
                    "ff",
                    {
                        limit   : limit,
                        offset  : offset
                    },
                    function(json){

                        if(!json.data.length){
                            vue_self.loading = false;
                        }else{
                            vue_instance_amigos.$data.data_amigos.push(json.data);
                        }
            },'json')
        //

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


                        // vue_instance_pessoas.$data.class_button = "msg-btn1";
                        // vue_instance_pessoas.$data.content_button = "Adicionar";
                    }
                    if(json === "add"){
                        $(".button-add-person:eq("+ l +")").addClass("msg-btn2");
                        $(".button-add-person:eq("+ l +")").removeClass("msg-btn1");
                        $(".button-add-person:eq("+ l +")").removeClass("msg-btn3");
                        $(".button-add-person:eq("+ l +")").html("");
                        $(".button-add-person:eq("+ l +")").html("Cancelar");

                    }

                },'json')

        },
        delete_amizade:function(id,l){

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


    },

});


$.post(
    "ff",
    {
        offset:0
    },
    function(json){

        if(typeof json.data != "undefined"){

            if(json.data.length){
                vue_instance_amigos.$data.data_amigos.push(json.data);
            }

        }


    },'json')

