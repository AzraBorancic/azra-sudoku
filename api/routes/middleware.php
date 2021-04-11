<?php
Flight::route('*', function (){
    if(str_starts_with(Flight::request()->url, '/users/')) return true;

    $headers = getallheaders();
    $token = @$headers['Authorization'];

    try{
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET", ['HS256']);
        Flight::set('user', $decoded);
        return true;
    } catch(\Exception $e){
        Flight::json(["Error" => $e->getMessage()], 401);
        die;
    }
});
