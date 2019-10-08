<?php

Route::set('index.php', function(){
    $name = 'Jack';
    Index::CreateView('Index', [
        'name' => $name
    ]);
});

Route::set('about-us', function(){
   AboutUs::CreateView('AboutUs');
   //AboutUs::test();
});

Route::set('contact-us', function(){
    ContactUs::CreateView('ContactUs');
});