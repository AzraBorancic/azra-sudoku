<?php

Flight::route('GET /sizes', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::sizeService()->get_sizes($offset, $limit, $order));
});
