if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
var home = {
    Url: function (metodo, params) {
        return App.url("", "home", metodo, params);
    }

};

var vm = new Vue({
      el: '#div-geral-time-line',
      data: {
          img_profile: '',
          img_cover: '',
          users_menu: [],
          path_img_profile_default: location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
          path_img_cover_default: location.origin + '/application/assets/libs/images/event-view/my-bg.jpg',
          path_img_time_line_default: location.origin + '/application/assets/libs/images/event-view/user-1.jpg',
          posts: [],
          loading: true,
          error_input_file: false,
          error_text_area: false,
          acData: [],
          inputData: '',
          focusIndex: '',
          inputFocus: false,
          action_like:'fas fa-heart',
          display_notification:'hide',
          name_new_message:'',
          offset:0

      },
      created () {
        window.addEventListener('scroll', this.handleScroll);
        this.getPosts()
      },
      mounted: function () {

          var self_vue = this;
          var url = "getimage";
          // ------------------profile-------------------
          $.post(url, { type: "profile" }, function (response) {self_vue.$data.img_profile = response.path;}, 'json');
          // -------------------cover-------------------
          $.post(url, { type: "cover" }, function (response) {self_vue.$data.img_cover = response.path;}, 'json');
          var url = "getimgmenu";
          // ------------------menu-pessoas-------------------
          $.post(url, {}, function (response) {
              self_vue.$data.users_menu = response.data.all_users;
          }, 'json');
      },
      methods: {
          getPosts () {
            var self_data = this.$data;

            $.post( "getstorageimg", {
              timeline:true,
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
          openfile: function () {
            $('#input-file-postagem').click();
          },
          excluir_postagem: function (id, posts, $index) {
            var url = "deletetimeline";
              $.post( url, { id: id },
                function (json) { if (json) { vm.posts.splice($index, 1)} }, 'json')
          },
          postar: function () {

              var data = new FormData();
              data.append('fileimagem', $('#input-file-postagem')[0].files[0]);
              data.append('text', $('#text-area-postagem').val());


              var url = "addtimeline";

              if ($('#input-file-postagem').val() == "") {
                  vm.error_input_file = true;
                  return false;
              } else {
                  vm.error_input_file = false;
              }
              if ($('#text-area-postagem').val() === "") {
                  vm.error_text_area = true;
                  return false;
              } else {
                  vm.error_text_area = false;
              }
              App.spinner_start();
              $.ajax({
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        var text_area = $('#text-area-postagem').val();
                        if (response) {
                            var data = {
                                'text': response.text_timeline,
                                'path': response.path,
                                '_id': response.id,
                              'img_profile':response.img_profile,
                              'created_at' : App.now('br')
                            };
                            vm.posts.unshift(data);
                        }
                      App.spinner_stop();
                    }
                }
              );

              $('#input-file-postagem').val("");
              $('#text-area-postagem').val("");
          },
          add_person: function (id, l) {
              $.post(
                "add",
                {
                    id: id
                },
                function (json) {
                    if (json === "delete") {
                        $(".div-confirmada-solicitacao:eq(" + l + ")").hide();
                        $(".btn-enviar-solicitacao:eq(" + l + ")").show();

                    }
                    if (json === "add") {
                        $(".div-confirmada-solicitacao:eq(" + l + ")").show();
                        $(".btn-enviar-solicitacao:eq(" + l + ")").hide();
                    }

                }, 'json')

          },
          redirect_user: function (id) {
              var url = App.url("", "dashboard", "");
              $.post(
                url,
                {
                    id: id
                },
                function (json) {
                    window.location.href = App.url("", "theirdashboard", "" + id);
                }, 'json')

          },
          compute_like: function (data,index) {
              var self = this;
              var url = "computelike";
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
        showImg ( path ) {
          vue_lightbox._data.imgs = path
           vue_lightbox._data.visible = true
           vue_lightbox._data.edit = false
        },

      }
  }
);

