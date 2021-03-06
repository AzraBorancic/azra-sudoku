<?php

/* Swagger documentation */
/**
 * @OA\Info(title="Sudoku game API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(url="http://localhost/azra-sudoku/api/", description="Development Environment")),
 *   @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authorization")
 */

/**
 * @OA\Get(path="/admin/users", tags={"x-admin"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements: -column_name for ascedning order or +column_name for descending order"),
 *     @OA\Response(response="200", description="List users from database"))
 */
Flight::route('GET /admin/users', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
/*  $search = Flight::query('search');*/
    $order = Flight::query('order', "-id");

    Flight::json(Flight::userService()->get_users($offset, $limit, $order));
});

/**
 * @OA\Get(path="/admin/users/{id}", tags={"x-admin"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Get user by id"),
 *     @OA\Response(response="200", description="Fetch individual account")
 * )
 */
Flight::route('GET /admin/users/@id', function($id){
    Flight::json(Flight::userService()->get_by_id($id));
});

/**
 * @OA\Post(path="/register", tags={"login"},
 *   @OA\RequestBody(description="Basic user info",required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    	 @OA\Schema(
 *    	   @OA\Property(property="name", required=true, type="string", example="First Name"),
 *         @OA\Property(property="surname", required=true, type="string", example="Last Name"),
 *         @OA\Property(property="email", required=true, type="string", example="myemail@gmail.com"),
 *         @OA\Property(property="password", required=true, type="string", example="12345")
 *         )
 *       )
 * ),
 * @OA\Response(response="200", description="User has been created")
 * )
 */
Flight::route('POST /register', function(){
    $data = Flight::request()->data->getData();
    Flight::userService()->register($data);
    Flight::json(["message" => "Confirmation email has been sent. Please confirm your account"]);
});

/**
 * @OA\Get(path="/confirm/{token}", tags={"login"},
 *     @OA\Parameter(type="string", in="path", name="token", default=123, description="Temporary token for activating account"),
 *     @OA\Response(response="200", description="Message upon successfull activation.")
 * )
 */
Flight::route('GET /confirm/@token', function($token){
    Flight::json(Flight::jwt(Flight::userService()->confirm($token)));
});

/**
 * @OA\Put(path="/admin/users/{id}", tags={"x-admin"}, security={{"ApiKeyAuth":{}}},
 *   @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic account info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="name", type="string", example=""),
 *                  @OA\Property(property="surname", type="string", example=""),
 *                  @OA\Property(property="email", type="string", example=""),
 *                  @OA\Property(property="password", type="string", example="")
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update account based on id")
 * )
 */
Flight::route('PUT /admin/users/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

/**
 * @OA\Post(path="/users/login", tags={"login"},
 *   @OA\RequestBody(description="Basic user info",required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    	 @OA\Schema(
 *         @OA\Property(property="email", required=true, type="string", example="myemail@gmail.com"),
 *         @OA\Property(property="password", required=true, type="string", example="12345")
 *          )
 *      )
 * ),
 * @OA\Response(response="200", description="User login")
 * )
 */
Flight::route('POST /login', function(){
    Flight::json(Flight::jwt(Flight::userService()->login(Flight::request()->data->getData())));
});

/**
 * @OA\Post(path="/forgot", tags={"login"}, description="Send recovery URL to users email address",
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", required="true", type="string", example="myemail@gmail.com",	description="User's email address" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that recovery link has been sent.")
 * )
 */
Flight::route('POST /forgot', function(){
    $data = Flight::request()->data->getData();
    Flight::userService()->forgot($data);
    Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
 * @OA\Post(path="/reset", tags={"login"}, description="Reset users password using recovery token",
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="token", required="true", type="string", example="123",	description="Recovery token" ),
 *    				 @OA\Property(property="password", required="true", type="string", example="123",	description="New password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has changed password.")
 * )
 */
Flight::route('POST /reset', function(){
    Flight::json(Flight::jwt(Flight::userService()->reset(Flight::request()->data->getData())));
});