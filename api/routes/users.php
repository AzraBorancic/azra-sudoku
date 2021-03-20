<?php

Flight::route('GET /users', function(){
    Flight::json(Flight::userService()->get_users("SELECT * FROM users", NULL));
});