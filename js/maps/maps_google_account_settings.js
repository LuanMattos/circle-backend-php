var config = {
    Url: function (metodo, params) {
        return App.url("account_settings/", "Account_settings", metodo, params);
    }
};

$(function() {

    var input = document.getElementById('searchTextField');
    var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ["geocode"]
        ,  componentRestrictions: {country: 'BR'}
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {

        var place = autocomplete.getPlace();
        var data = new Object();
        data.formatted_address_google_maps = place.formatted_address;
        data.latitude = place.geometry.location.lat();
        data.longitude = place.geometry.location.lng();

        if(data.formatted_address_google_maps !== ""){
            $.post(
                "asl",
                {
                    data:data
                },function(){

                },'json')
        }


    });

});