<?php

//var_dump($_SERVER);
//var_dump($_REQUEST);
define("APP_PATH", "");
include './Common/config/config.php';
include './Common/mysql/mysql.php';
include './Common/functions/functions.php';
$mydb=new mysql();
$sql="select * from weixin_access_token";
var_dump($mydb->selectOne($sql));