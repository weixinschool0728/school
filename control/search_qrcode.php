<?php

date_default_timezone_set('PRC'); //设置中国时区 
include_once '../Common/mysql/db.php';
$db = db::getInstance();
$last = $_POST['last'];
$amount = $_POST['amount'];
$sql = "SELECT 	* FROM weixin_child limit $last,$amount";
$c = $db->selectAll($sql);
echo json_encode($c);