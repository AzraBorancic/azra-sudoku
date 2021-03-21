<?php
require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';

class UserService extends BaseService{

    public function __construct(){
        $this->dao = new UserDao();
    }

    public function get_users($offset, $limit, $order){
        return $this->get_all($offset, $limit, $order);
    }

    public function register($user){
        $this->dao->beginTransaction();

        try {

            $user = parent::add([
                "name" => $user['name'],
                "surname" => $user['surname'],
                "email" => $user['email'],
                "password" => $user['password'],
                "status" => "PENDING",
                "created_at" => date(Config::DATE_FORMAT),
                "token" => md5(random_bytes(16))
            ]);

        } catch (\Exception $e) {
            $this->dao->rollBack();
            if (str_contains($e->getMessage(), 'users.eq_user_email')) {
                throw new Exception("Account with same email exists in the database", 400, $e);
            }else{
                throw new Exception("Invalid request body!", 400, $e);
            }
        }
        $this->dao->commit();

        // TODO: send email with some token

        return $user;
    }

    public function confirm($token){
        $user = $this->dao->get_user_by_token($token);

        if (!isset($user['id'])) throw Exception("Invalid token");

        $this->dao->update($user['id'], ["status" => "ACTIVE"]);

        //TODO send email to customer
    }

}