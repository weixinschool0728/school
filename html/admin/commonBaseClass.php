<?php

/* 
 *用户登录 
 * 引入公共部分文件
 * 
 */
session_start();
include_once '../../Common/config/config.php';
include_once '../../Common/mysql/db.php';
include_once '../../Common/functions/functions.php';

class BaseClass{
//    private $mydb=null;
    
    function __construct() {
        if(!isset($_SESSION['user']['username'])||!$_SESSION['user']['username']){
            $_SESSION['ref']=base64_encode($_SERVER['REQUEST_URI']);
            header("location:./login.php");
        }        
    }
}