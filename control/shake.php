<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Common/mysql/db.php';
$db = db::getInstance();
$id = isset($_GET['id']) ? $_GET['id'] : '-1';
$d = $id . ':' . date('Y-m-d h:i:s') . "\n";
$created = time();
$sql = "INSERT INTO weixin_shake (openid, created,deleted)VALUES('" . $id . "', '" . $created . "', '0')";
$table = "weixin_shake";
$data = array(
    'openid' => $id,
    'created' => $created,
    'deleted' => 0
);
$r = $db->insert($table, $data);


$sql = "SELECT * FROM weixin_shake WHERE openid='" . $id . "' AND deleted=0";
$r = $db->selectAll($sql);

$data = array(
    'deleted' => 1
);

//$r = $db->update($table, $data, "s_id=2");
$r = $db->delete($table, "s_id=111");
var_dump($r);
exit();
$mysql->fetch_array($sql, "MYSQL_BOTH");
file_put_contents('shake.txt', $sql, FILE_APPEND);
$value = array('statu' => 1);
echo json_encode($value);
