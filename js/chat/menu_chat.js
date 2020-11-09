var vue_instance_menu_chat = new Vue({
  el:"#hangout",
  data:{
    amigos : [],
    path_img_profile_default : location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
    chat:false

  },
  mounted : function(){
    this.get_amigos_chat();
  },
  methods:{
    get_amigos_chat:function(){
      var self = this;
      var url = "friendchat";

      App.spinner_start();
      axios({ method: 'post', url : url, data : {} })
        .then(function( json ){ self.amigos = json.data.data; App.spinner_stop();});
    },
    open_chat:function( data ){
      var login = data.login;
      var self = this;
      var url  = "getmsg";
      const params = new URLSearchParams();
      this.chat = true;
      vue_instance_chat._data.messages = [];
      App.spinner_chat_start();

      params.append('login', login);
      axios({ method: 'post', url : url, data : params })
        .then(function( json ){

            vue_instance_chat._data.data_user = json.data;
            vue_instance_chat._data.img_profile = json.data.usuario.img_profile;


            if(json.data.data) {
              json.data.data.msg.map(function (el,index ) {
                el.img_profile = json.data.usuario.img_profile;
                }
              )
              vue_instance_chat._data.messages = json.data.data.msg;
            }
            App.spinner_chat_stop();
          }
        );
      var chat = $(".chat-content");

      if( chat.is(":visible") ){
        return false;
      }
      chat.toggleClass('hide');

      setTimeout(function(){
        self.scrollDown();
      },'100')

    },
    setDate:function(date){
      var d = new Date(toString());
      var m = '';
      if (m != d.getMinutes()) {
        m = d.getMinutes();
        $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
      }
    },
    close_menu_chat:function(){
      $(".content-menu-chat").toggleClass('hide-transition');
    },
    scrollDown: function() {
      var height = document.querySelector(".messages-content").scrollHeight;
      $('.messages-content').scrollTop(height);
    },
  }
})


var GLOBALSTATE = {
  route: '.list-account'
};

setRoute(GLOBALSTATE.route);
$('.nav > li[data-route="' + GLOBALSTATE.route + '"]').addClass('active');

setName(localStorage.getItem('username'));

if (localStorage.getItem('color') !== null) {
  var colorarray = JSON.parse(localStorage.getItem('color'));
  stylechange(colorarray);
} else {
  var colorarray = [51,102,153,1];
  localStorage.setItem('color', JSON.stringify(colorarray));
  stylechange(colorarray);
}


function setName(name) {
  $.trim(name) === '' || $.trim(name) === null ? name = 'Taras Anichin' : name = name;
  $('h1').text(name);
  localStorage.setItem('username', name);
  $('#username').val(name).addClass('used');
  $('.card.menu > .header > h3').text(name);
}


function stylechange(arr) {
  var x = 'rgba(' + arr[0] + ',' + arr[1] + ',' + arr[2] + ',1)';
}

function setRoute(route) {
  GLOBALSTATE.route = route;
  $(route).addClass('shown');

  if (route !== '.list-account') {
    $('#add-contact-floater').addClass('hidden');
  } else {
    $('#add-contact-floater').removeClass('hidden');
  }

  if (route !== '.list-text') {
    $('#chat-floater').addClass('hidden');
  } else {
    $('#chat-floater').removeClass('hidden');
  }

  if (route === '.list-chat') {
    $('.mdi-menu').hide();
    $('.mdi-arrow-left').show();
    $('#content').addClass('chat');
  } else {
    $('#content').removeClass('chat');
    $('.mdi-menu').show();
    $('.mdi-arrow-left').hide();
  }
}




$('.search-filter').on('keyup', function() {
  var filter = $(this).val();
  $(GLOBALSTATE.route + ' .list > li').filter(function() {
    var regex = new RegExp(filter, 'ig');

    if (regex.test($(this).text())) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
});

