var App = {}

    /**
    * Url padrão Codegniter com Modulos
    **/

    App.url = function (modulo, controller, methods, params) {

        if (modulo === '') {
            if(typeof (params) !== 'undefined'){
                return window.origin +  "/"  + controller + "/" + methods + "/" + params
            }
            return window.origin +  "/"  + controller + "/" + methods
        }
        if (typeof (params) !== 'undefined') {
            return window.origin + "/" + modulo + "/" + controller + "/" + methods + "/" + params
        } else {
        return window.origin + "/"  + modulo + "/" + controller + "/" + methods
        }
    },

    /**
     * Busca todas as informações do Form, inclusive os com attributo disabled
    **/

    App.form_data = function(form){

        function getDisableInput(form) {
            var input = $(form + " input:disabled");
            var result = '';
            $.each(input, function (key, val) {
                result += "&" + val.name + '=' + val.value;
            });
            return result;
        }

        var disableInput = getDisableInput(form);
        return $(form).serialize() + disableInput;

    // if(typeof form != "undefined"){
    //     return $(form).serializeArray();
    // }
    }
    App.production = function(){
        if( window.location.host !== 'localhost' ){
            return true;
        }
        return false;
    }
    App.spinner_start = function(){
        var html = "<div class='spinner-atos'><div class='loader'></div></div>";
        $('body').append(html);
    }
    App.spinner_stop = function(){
        $('.spinner-atos').remove();
    }
   App.spinner_chat_start = function(){
        var html = "<div class='spinner-atos-chat'><div class='loader'></div></div>";
        $('#content-chat').find('.chat-content').append(html);
    }
    App.spinner_chat_stop = function(){
        $('.spinner-atos-chat').remove();
    }
    App.now = function(format = 'br'){
        var value   = false;
        var d       = new Date();
        var day     = ( parseInt( d.getDay() )   < 10 ? '0' + d.getDay().toString()   : d.getDay()   );
        var month   = ( parseInt( d.getMonth() ) < 10 ? '0' + d.getMonth().toString() : d.getMonth() );
        var time    = ( parseInt( d.getHours() ) < 10 ? '0' + d.getHours().toString() : d.getHours() )
                        + ':'  +
          ( parseInt( d.getMinutes() ) < 10 ? '0' + d.getMinutes().toString() : d.getMinutes() )
                        + ':'  +
          ( parseInt( d.getSeconds() ) < 10 ? '0' + d.getSeconds().toString() : d.getSeconds() );

        switch ( format ) {
            case 'time':
                value =  time.toString();
            break;
            case 'br':
                value = day + "/" + month + "/" + d.getFullYear();
            break;
            case 'us':
                value =  day + "-" + month + "-" + d.getFullYear();
            break;
            case 'timestamp':
                value = d.getFullYear() + '-' + month + '-' + day;
            break;
        }
        !value ? console.warn('Format date is invalid!'):'';

        format != 'time' ? value += " " + time:'';

        return value.toString();
    }

$(document).ready(function(){
    $(".content-open-menu-chat").on("click",function(){
        $(".content-menu-chat").toggleClass('hide-transition');
    })

})

Vue.filter('firstUpperCase', function (value) {
    function pri_mai(text){
        if(!_.isUndefined(text)) {
            var str = text;
            qtd = text.length;
            prim = str.substring(0, 1);
            resto = str.substring(1, qtd);
            str = prim.toUpperCase() + resto;
            text = str;
            return text;
        }
    }
    return pri_mai(value)
})
Vue.filter('parseint', function (value) {
    return parseInt(value);

})
Vue.filter('crop_string', function (string,size) {
    if(size){
        return string.substring(0, size) + "...";
    }
    return string.substring(0, 30) + "...";
})
$(document).ready(function(){
    if(App.production()){
        $(document).keydown(function (event) {
                    if (event.keyCode == 123) {
                                return false;
                            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
                                return false;
                        }
                    }
                )
                $(document).on("contextmenu", function (e) {
                  e.preventDefault();
               }
            )
        }
    }
)
