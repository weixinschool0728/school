<?php
date_default_timezone_set('PRC'); //设置中国时区 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Common/mysql/db.php';
$db = db::getInstance();
$id = isset($_GET['id']) ? $_GET['id'] : '-1';
$created = time();
$table = "weixin_shake";
$data = array(
    'openid' => $id,
    'created' => $created,
    'deleted' => 0
);
$db->insert($table, $data);
$t= $db->selectOne("SELECT MIN(created) as s,MAX(created) as e FROM weixin_shake WHERE openid='{$id}' AND deleted=0");
$start=$t['s'];
$end=$t['e'];
$sql = "SELECT count(1) as c FROM weixin_shake WHERE openid='{$id}' and created>='{$start}' and created<='{$end}'";
$c = $db->selectOne($sql);
$info=array(
    'total'=>$c['c'],
    'start'=> date('Y-m-d H:i:s', $start),
    'end'=> date('Y-m-d H:i:s', $end)
);
//file_put_contents('test.txt', $id."\n",FILE_APPEND);
echo json_encode($info);
