<?php

/**
 * @OA\Get(
 *     path="/users",
 *     @OA\Response(response="200", description="List users form database"))
 */

Flight::route('GET /users', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::userService()->get_users($offset, $limit, $order));
});

/**
 * @OA\Info(title="Sudoku game API", version="0.1")
 */

/**
 * @OA\Post(
 *     path="/users/register",
 *     @OA\Response(response="200", description="Add user to dabase"))
 */

Flight::route('POST /users/register', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->register($data));
});

/**
 * @OA\Info(title="Sudoku game API", version="0.1")
 */

/**
 * @OA\Get(
 *     path="/users/confirm/{token}",
 *     @OA\Parameter(@OA\Schema(type="string"), in="path", allowReserved=true, name="token", example=1))
 *     @OA\Response(response="200", description="Get user account status")
 */

Flight::route('GET /users/confirm/@token', function($token){
    Flight::userService()->confirm($token);
    Flight::json(["message" => "Your account has been activated"]);
});