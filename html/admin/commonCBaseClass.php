<?php

/*
 * 用户登录 
 * 引入公共部分文件
 * 
 */
include_once './commonBaseClass.php';

class CBaseClass extends BaseClass {

    public $mydb = null;

    function __construct() {
        parent::__construct();
        $this->mydb = db::getInstance();
    }

}
