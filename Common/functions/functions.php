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
