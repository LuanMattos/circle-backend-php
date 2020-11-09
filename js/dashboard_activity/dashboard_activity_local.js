if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
var dashboard_activity_local = {
    Url: function (metodo, params) {
        return App.url("dashboard_activity", "Dashboard_activity", metodo, params);
    }
};

var vue_instance_dashboard_activity_local = new Vue({
    el: "#div-geral-dashboard_activity",
    data: {
        posts   : [],
        amigos  : [],
        path_img_time_line_default : location.origin + '/application/assets/libs/images/dp.jpg',
        action_like:'fas fa-heart',
        display_notification:'hide',
        name_new_message:'',
        offset:0,
        loading:true
    },
    created () {
        window.addEventListener('scroll', this.handleScroll);
        this.getPosts(5)
    },
    mounted:function(){
        var self_vue  = this;
        // -------------------------------------------
        var url       = "abul";
        $.post(url, {}, function(response){ self_vue.$data.amigos = response.data.amigos; },'json');
    },
    methods:{
        getPosts () {
            var self_data = this.$data;
            $.post( "gsi", {
                limit:1,
                offset:this.offset
            }, function(json){
                if( json.data.length ){
                        var values = self_data.posts.filter(function (){
                            return json.data[0]._id;
                            }
                        )
                    if( values ){
                        self_data.posts.push( json.data[0] );
                    }
                }
            },'json');

            self_data.loading = false;
            this.offset ++;
        },
        handleScroll() {
            let scrollHeight = window.scrollY
            let maxHeight = window.document.body.scrollHeight - window.document.documentElement.clientHeight

            if (scrollHeight >= maxHeight - 200) {
                this.getPosts()
            }
        },
        smartTrim(string, maxLength) {
            var trimmedString = string.substr(0, maxLength);
            return trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
        },
        close_notify :function(){
            this.display_notification = 'hide';
        },
        excluir_postagem:function( id, posts ,$index){

            $.post(
                "dt",
                {
                    id:id
                },
                function(json){
                    if(json){
                        vue_instance_dashboard_activity_local.posts.splice($index, 1)
                    }
                    if(!json){
                    }

                },'json')
        },
        redirect_user:function(login){
            var url = App.url("","dashboard","");

            $.post(
                url,
                {
                    login:login
                },
                function(json){
                    window.location.href = App.url("","external","" + json.login);
                },'json')
        },

        open_chat : function(){
            $(".chat-content").toggleClass('hide');

        },
        showImg ( path ) {
            vue_lightbox._data.imgs = path
            vue_lightbox._data.visible = true
            vue_lightbox._data.edit = false

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
    }

    }
);

