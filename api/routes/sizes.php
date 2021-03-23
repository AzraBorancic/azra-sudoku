<?php

/**
 * @OA\Info(title="Sudoku game API", version="0.1")
 */

/**
 * @OA\Get(
 *     path="/sizes",
 *     @OA\Response(response="200", description="List puzzle sizes")
 * )
 */

Flight::route('GET /sizes', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::sizeService()->get_sizes($offset, $limit, $order));
});
