<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include_once '../Common/mysql/db.php';
//include_once '../Common/config/config.php';
//include_once '../Common/functions/functions.php';

class UserInfo {

    private $url = null;
    private $access = null;
    private $returns = array(
        "state" => 0,
        "message" => ""
    );

    function __construct($accessToken = '') {
        if ($accessToken == "") {
            $this->access = getAccessToken(WEI_ID);
        } else {
            $this->access = $accessToken;
        }
    }

    public function getUserInfo($openid) {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->access . "&openid=" . $openid . "&lang=zh_CN";
        $res = json_decode(file_get_contents($url), TRUE);

        if (isset($res['errcode'])) {
            return false;
        } else {
            return $res;
        }
    }

}
