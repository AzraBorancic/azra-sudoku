<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/services/UserService.class.php';
require_once dirname(__FILE__).'/services/LevelService.class.php';
require_once dirname(__FILE__).'/services/SizeService.class.php';
use Firebase\JWT\JWT;

Flight::set('flight.log_errors', TRUE);

/* error handling for our API */
Flight::map('error', function(Exception $ex){
    Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
});

/* utility function for reading query parameters from URL */
Flight::map('query', function($name, $default_value = NULL){
    $request = Flight::request();
    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
});

Flight::route('GET /swagger', function(){
    $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
    header('Content-Type: application/json');
    echo $openapi->toJson();
});

Flight::route('GET /', function(){
    Flight::redirect('/docs');
});

/* register Business Logic layer services */
Flight::register('userService', 'UserService');
Flight::register('levelService', 'LevelService');
Flight::register('sizeService', 'SizeService');

/* include all routes */
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/users.php";
require_once dirname(__FILE__)."/routes/levels.php";
require_once dirname(__FILE__)."/routes/sizes.php";

Flight::start();