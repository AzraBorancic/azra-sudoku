<?php

Flight::route('GET /users', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::userService()->get_users($offset, $limit, $order));
});

Flight::route('POST /users/register', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->register($data));
});

Flight::route('GET /users/confirm/@token', function($token){
    Flight::userService()->confirm($token);
    Flight::json(["message" => "Your account has been activated"]);
});