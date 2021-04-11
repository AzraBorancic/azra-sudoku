<?php
/* middleware for admin users */
Flight::route('/admin/*', function(){
    try {
        $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"),"JWT_SECRET", ["HS256"]);
        if ($user['r'] != "ADMIN"){
            throw new Exception("Admin access required", 403);
        }
        Flight::set('user', $user);
        return true;
    } catch (\Exception $e) {
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
});