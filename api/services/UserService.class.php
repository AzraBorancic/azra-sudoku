<?php
require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';
require_once dirname(__FILE__).'/../dao/AccountDao.class.php';

class UserService extends BaseService{

    public function __construct(){
        $this->dao = new UserDao();
    }

    public function get_users($query, $params){
        return $this->list($query, $params);
    }

}
?>