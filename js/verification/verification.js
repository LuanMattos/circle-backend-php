var verification = {
    Url: function (metodo, params) {
        return App.url("verification/", "Verification", metodo, params);
    }
}
$(function(){

    var vue_instance = new Vue({
        el: "#general-verification-container",
        data: {
            form:{
                codevalidation:"",
                error:""
            }
        }
    });

    $("#comecar").on("click",function(){
        $.post(
            verification.Url("validate_code"),
            {
                data: vue_instance.form.codevalidation,
            },
            function (j) {
                if(!j.info){
                    vue_instance.form.error = j.error;
                    return false;
                }
                if(j.info){
                    window.location.href = App.url("","Home","index");
                }


            }, 'json');

    })
})