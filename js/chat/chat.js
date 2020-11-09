var chat = {
    Url: function (metodo, params) {
        return App.url("area_a", "Area_a", metodo, params);
    }
}
var vue_instance_chat = new Vue({
    el : "#content-chat",
    data : {
        data_users               : [],
        img_profile              : '',
        img_cover                : '',
        path_img_profile_default : location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
        path_img_cover_default   : location.origin + '/application/assets/libs/images/event-view/my-bg.jpg',
        messages_content         : '',
        Fake                     : [],
        ico_minimize_maximise    : 'fas fa-window-minimize',
        minimize_class           : '',
        user                     : '',
        text                     : null,
        messages                 : [],
        ws                       : null,
        data_user                : '',
        status                   : [],
        here                     : false,
        user_local               : false
    },
    mounted : function(){

      var self_vue  = this;

      //dados usuario externo

      var id  = window.location.href.split("external/")[1];
      const params = new URLSearchParams();

      params.append('id', id);
      axios({ method: 'post', url : "getmsg/" + true, data : params }).then(function( json ){ self_vue.data_user = json.data;});
      // ------------------profile-------------------
      $.post("getimage", {type : "where",id : id}, function(response){self_vue.$data.img_profile = response.path;},'json');
      // ------------------cover------------------
      //dados usuario local
      axios({ method: 'post', url : App.url("dashboard_msg","Dashboard_msg","get_msg",""), data : null })
        .then(function( json ){ console.log(json.data); self_vue.user_local = json.data;self_vue.connect();
        });

    },
    methods:{
        connect: function(onOpen) {
            var self = this;
            var _id = this._data.user_local.usuario.id;

            if(!_.isUndefined(_id) && !_.isEmpty(_id)){
              if (window.location.host == 'localhost' ){
                self.ws = new WebSocket('wss://localhost:8090?' + this._data.user_local.usuario.login);
              }else{
                self.ws = new WebSocket('wss://' + window.location.host + ':8090?' + this._data.user_local.usuario.login);
              }

            }else{
                console.debug("Usuário não possui identificação válida!");
                return false;
            }

            self.ws.onopen = function(e) {
                self.addSuccessNotification('Online');
                if (onOpen) {
                    onOpen();
                }
            };

            self.ws.onerror = function(e) {
                self.addErrorNotification('Não foi possível conectar-se ao servidor');
            };

            self.ws.onmessage = function(e) {
                self.addMessage(e.data);
            };

        },
        setDate:function(){
            var d = new Date();
            var m = '';
            if (m != d.getMinutes()) {
                m = d.getMinutes();
                $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
            }
        },
        minimize_maximize : function(){

            switch (this.ico_minimize_maximise) {
                case 'fas fa-window-minimize' :
                    this.ico_minimize_maximise = 'fas fa-level-up-alt';
                    this.minimize_class = 'minimize-chat';
                    break;
                case 'fas fa-level-up-alt' :
                    this.ico_minimize_maximise = 'fas fa-window-minimize';
                    this.minimize_class = '';
                    break;

            }

        },
        close:function(event){
            $(event.target).parent().parent().parent().parent().parent().addClass('hide');
            vue_instance_menu_chat.chat = false;
        },
        addMessage: function(param) {

          if( param.length ) {
            var data = JSON.parse(param);

            var login_usuario_chat = this.data_user.usuario.login;

            if (typeof vm !== 'undefined') {
              vm.name_new_message = data.from_name;

              if (!vue_instance_menu_chat.chat) {
                vm.display_notification = false;
                setTimeout(function () {
                  vm.display_notification = 'hide';
                }, '5100')
              } else {
                vm.display_notification = 'hide';
              }
            } else if (typeof vue_instance_dashboard_activity_local !== 'undefined') {
              vue_instance_dashboard_activity_local.name_new_message = data.from_name;

              if (!vue_instance_menu_chat.chat) {
                vue_instance_dashboard_activity_local.display_notification = false;
                setTimeout(function () {
                  vue_instance_dashboard_activity_local.display_notification = 'hide';
                }, '5100')
              } else {
                vue_instance_dashboard_activity_local.display_notification = 'hide';
              }

            }

            if (login_usuario_chat === data.from) {
              this.messages.push(data);
            }
            this.scrollDown();

            //escuta
          }
        },
        //envia
        sendMessage: function() {
        var login = this.data_user.usuario.login;
        var login_local = this.user_local.usuario.login;
        var data_from = this.user_local.usuario;

        var self = this;
        if(!_.isEmpty(this.text))
        var data_msg = { text : this.text,
                         date : this.setDate(),
                         user : this.data_user.usuario.nome,
                         to : this.data_user.usuario.login,
                         from : login_local
            };

        if ( !this.text ) {
          return false;
        }

        this.messages.push( data_msg );

        $('.messages-content').appendTo($('.mCSB_container')).addClass('new');

        if (self.ws.readyState !== self.ws.OPEN) {
          self.addErrorNotification('Problemas na conexão. Tentando reconectar...');

          self.connect(function() {
            self.sendMessage();
          });

          return;
        }

        var url = "getmsg";
        const params = new URLSearchParams();
        params.append('login', login);
        axios({ method: 'post', url : url, data : params })
          .then(function( json ){
            var idchat = json.data.usuario.idchat;

            self.ws.send(JSON.stringify({
              user        : self.data_user.usuario.nome,
              text        : self.text,
              img_profile : self.user_local.usuario.img_profile,
              class_text  : 'msg-local-here',
              idchatTo    : idchat,
              command     : 'message',
              to          : self.data_user.usuario.login,
              recebendo   : true,
              from        : login_local,
              from_name   : data_from.nome
            }));

            self.text = null;
            self.here = true;
            self.scrollDown();

          });



        },
        addMessageNotification:function(data){
            this.status = [];
            this.status.push(data);
        },
        // Método responsável por adicionar uma notificação de sucesso
        addSuccessNotification: function(text) {
            this.addMessageNotification({color: '#5490fe', text: text});
        },
        // Método responsável por adicionar uma notificação de erro
        addErrorNotification: function( text ) {
            this.addMessageNotification({color: '#a7acaa', text: text});
        },
        // Método responsável por "rolar" a scroll do chat para baixo
        scrollDown: function() {
            var height = document.querySelector(".messages-content").scrollHeight + 100
            $('.messages-content').scrollTop(height);

        },
    },
});








