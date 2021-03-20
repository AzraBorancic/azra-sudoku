<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__). "/dao/UserDao.class.php";

$user_dao = new UserDao();
//$ user = $user_dao->get_user_by_id(3);

/*$user1 = [
    "name" => "Amila Bo",
    "email" => "amila@gmail.com",
    "password" => 123,
    "account_id" => 2

];
$user = $user_dao->add_user($user1);
*/
$user1 = [
    "password" => 133,

];
$user = $user_dao->update_user_by_email("azra@gmail.com", $user1);

//we take the id from the db
//$user = $user_dao->update_user(11, $user1);

print_r($user);