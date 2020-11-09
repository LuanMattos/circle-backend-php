if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
var dashboard_activity_external = {
    Url: function (metodo, params) {
        return App.url("dashboard_activity", "Dashboard_activity", metodo, params);
    }

};
var vue_instance_dashboard_activity_external = new Vue({
    el: "#div-geral-dashboard_activity",
    data: {
        posts   : [],
        amigos  : [],
        path_img_time_line_default : location.origin + '/application/assets/libs/images/dp.jpg',
        action_like:'fas fa-heart',
        display_notification:'hide',
        name_new_message:'',
        loading:false,
        data_user_local:false


    },
    mounted:function(){
        var id = window.location.href.split("external/")[1];
        var self_vue  = this;
        // ------------------profile-------------------

        $.post(App.url("","abul",""), { id : id }, function(response){ self_vue.$data.amigos = response.data.amigos;},'json');
        $.post( App.url("","gsi",""), { id : id }, function(json){ vue_instance_dashboard_activity_external.$data.posts = json.data; },'json')
        $.post( App.url("","du",""), {}, function(json){ vue_instance_dashboard_activity_external.$data.data_user_local = json.data; },'json')
        },
    methods:{
        redirect_user:function(id){
            $.post(App.url("","dashboard",""), { id:id }, function(json){ window.location.href = App.url("","external/","" + json.login); },'json')
        },
        open_chat : function(external){
            if(external){
                $(".chat-content").toggleClass('hide');
            }
        },
        compute_like: function (data,index) {
            var self = this;
            var url = "cl";
            var qtd = this.posts[index].count_like;

            const params = new URLSearchParams();
            params.append('id', data._id);
            axios({ method: 'post', url: url, data: params }).then(function (json) {
                if(json.data === 'like'){
                    $(".left-comments:eq(" + index + ")").find(".fa-heart").addClass('text-like');
                    self.posts[index].count_like = qtd + 1;
                }else if(json.data === 'dislike'){
                    $(".left-comments:eq(" + index + ")").find(".fa-heart").removeClass('text-like');
                    self.posts[index].count_like = qtd - 1;
                }

            });
        },
        showImg ( path) {
            vue_lightbox._data.imgs = path;
            vue_lightbox._data.visible = true;
            vue_lightbox._data.edit = false;
        },
    }
    }
);


