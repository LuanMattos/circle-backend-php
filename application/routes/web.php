<?php

Route::get('/', function(){
    luthier_info();
})->name('Home@index');

Route::set('404_override', function(){
    show_404();
});

Route::set('translate_uri_dashes',FALSE);


