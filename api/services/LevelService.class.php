<?php
require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/LevelDao.class.php';

class LevelService extends BaseService{

    public function __construct(){
        $this->dao = new LevelDao();
    }

    public function get_levels($offset, $limit, $order){
        return $this->get_all($offset, $limit, $order);
    }
}