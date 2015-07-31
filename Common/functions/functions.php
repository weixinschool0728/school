<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function br() {
    echo "<br>";
}

//function getAccessToken($wei_id = 1) {
//    $data = json_decode(file_get_contents("access_token.json"));
//    if ($data->expire_time < time()) {
//        // 如果是企业号用以下URL获取access_token
//        // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
//        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
//        $res = json_decode($this->httpGet($url));
//        $access_token = $res->access_token;
//        if ($access_token) {
//            $data->expire_time = time() + 7000;
//            $data->access_token = $access_token;
//            $fp = fopen("access_token.json", "w");
//            fwrite($fp, json_encode($data));
//            fclose($fp);
//        }
//    } else {
//        $access_token = $data->access_token;
//    }
//    return $access_token;
//}

function getAccessToken($wei_id = 1) {

    $mydb = db::getInstance();
    $sql = "select * from weixin_access_token where delated=0 and wei_id=" . $wei_id;
    $accessTokenArr = $mydb->selectOne($sql);
    if (empty($accessTokenArr) || time() - $accessTokenArr["created"] > 7000 || empty($accessTokenArr['access_token'])) {
        //重新获取token  并存数据库
        $accessTokenArr = getAccessTokenByUrl();
        if (isset($accessTokenArr['access_token'])) {
            $data = array(
                "created" => time(),
                "access_token" => $accessTokenArr['access_token'],
            );
            if ($mydb->update("weixin_access_token", $data, "wei_id = " . $wei_id, false)) {
                return $accessTokenArr['access_token'];
            } else {
                return FALSE;
            }
        } else {
            return false;
        }
    } else {
        return $accessTokenArr['access_token'];
    }
}

function getAccessTokenByUrl() { // php kaiqi openssl扩展
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type="
            . "client_credential&appid=" . APPID . "&secret=" . APPSECRET;
    $accessTokenArr = json_decode(file_get_contents($url), true);
    return $accessTokenArr;
}

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

//curl 模拟 post 提交 https
function httpsPost($url, $data) { // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        return false;
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}

function jsonencode($value) {
    if (version_compare(PHP_VERSION, '5.4.0', '<')) {
        $str = json_encode($value);
        $str = preg_replace_callback(
                "#\\\u([0-9a-f]{4})#i", function( $matchs) {
            return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
        }, $str       
                );
        return $str;
    } else {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}