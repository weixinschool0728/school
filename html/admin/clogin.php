<?php
session_start();
if (isset($_POST['inputname']) && $_POST['inputname'] != "") {
    include_once './common/config.php';
    include_once '../../Common/functions/functions.php';
    include_once '../../Common/mysql/db.php';
    $post = post();
    $mydb = db::getInstance();
    $pass = md5($post['pass']);
    $username = $post['inputname'];
    $sql = "SELECT name,user_type,id FROM weixin_user WHERE delated=0 AND password='{$pass}' AND name='{$username}' ";
    $res = $mydb->selectOne($sql);
    if ($res) {

        $_SESSION['user']['username'] = $res['name'];
        $_SESSION['user']['user_type'] = $res['user_type'];
        $_SESSION['user']['id'] = $res['id'];
        if (isset($_SESSION['ref']) && $_SESSION['ref'] != "") {
            header("location:" . base64_decode($_SESSION['ref']));
        } else {
            header("location:./index.php");
        }
    } else {
        echo '<script>alert("登陆失败！");window.location.href="./login.php";</script>';
    }
} else {
    echo '<script>alert("数据为空！");window.location.href="./login.php";</script>';
}
?>
