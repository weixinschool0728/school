<?php

date_default_timezone_set('PRC'); //设置中国时区 
include_once '../Common/mysql/db.php';
$db = db::getInstance();
$c_no = isset($_GET['c_no']) ? $_GET['c_no'] : '';
$opid = isset($_GET['opid']) ? $_GET['opid'] : '';
$c_no = "sc000001";
$opid = "oC62huElTtHZ8BoR5Fju2o2q20io";
$info = array(
    'statu' => 0,
    'total' => '5',
    'mesg' => "参数错误"
);
if (empty($c_no) || empty($opid)) {
    echo json_encode($info);
    exit();
}
//判断这个用户是否关注
$sql = "select count(1) as c from weixin_attention where delated=0 and openid='{$opid}'";
$c = $db->selectOne($sql);
if ($c['c'] > 0) {
    $sql = "select count(1) as c from weixin_like where deleted=0 and c_no='{$c_no}' and openid='{$opid}'";
    $c = $db->selectOne($sql);
    if ($c['c'] == 0) {
        //写入点赞表
        $data = array(
            c_no => $c_no,
            openid => $opid,
            created => time(),
            deleted => '0'
        );
        $id = $db->insert('weixin_like', $data);
        if ($id) {
            $info['statu'] = 1;
            $info['mesg'] = '投票成功';
        } else {
            //投票失败
            $info['statu'] = 2;
            $info['mesg'] = '投票失败';
        }
    } else {
        //已经投了
        $info['statu'] = 3;
        $info['mesg'] = '已经投过此票';
    }
    //统计这个用户有多少赞 返回给前台
    $sql = "SELECT COUNT(1) AS c FROM weixin_like AS l INNER JOIN weixin_child AS c ON l.c_no=c.c_no WHERE l.c_no='{$c_no}'";
    $c = $db->selectOne($sql);
    $info['total'] = $c['c'];
} else {
    //没有关注
    $info['statu'] = 4;
    $info['mesg'] = '还没有关注';
    $info['total'] = -1;
}
echo json_encode($info);
