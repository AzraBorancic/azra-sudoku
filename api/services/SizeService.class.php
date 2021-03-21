<?php
require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/SizeDao.class.php';

class SizeService extends BaseService{

    public function __construct(){
        $this->dao = new SizeDao();
    }

    public function get_sizes($offset, $limit, $order){
        return $this->get_all($offset, $limit, $order);
    }
}