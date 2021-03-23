<?php

/* Swagger documentation */
/**
 * @OA\Info(title="Sudoku game API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(url="http://localhost/azra-sudoku/api/", description="Development Environment")
 * )
 */

/**
 * @OA\Info(title="Sudoku game API", version="0.1")
 */

/**
 * @OA\Get(
 *     path="/levels",
 *     @OA\Response(response="200", description="List level difficulties")
 * )
 */

Flight::route('GET /levels', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::levelService()->get_levels($offset, $limit, $order));
});
