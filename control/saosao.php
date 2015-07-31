<?php

function makeCNo($number, $prefix = "sc", $length = "6") {

    if (empty($number) || strlen($number) == 0) {
        return false;
    }
    if (strlen($number) >= $length) {
        return $prefix . $number;
    }
    $str = str_repeat('0', $length - strlen($number));
    return $prefix . $str . $number;
}
date_default_timezone_set('PRC'); //设置中国时区 
include_once '../Common/mysql/db.php';
$db = db::getInstance();
$c_no = isset($_GET['c_no']) ? $_GET['c_no'] : '';
$opid = isset($_GET['opid']) ? $_GET['opid'] : '';
$created = time();
if (empty($c_no) || empty($opid)) {
    
}