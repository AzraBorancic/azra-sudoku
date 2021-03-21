<?php

Flight::route('GET /levels', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::levelService()->get_levels($offset, $limit, $order));
});
