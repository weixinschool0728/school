<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../Common/mysql/db.php';
include_once '../Common/config/config.php';
include_once '../Common/functions/functions.php';

class UserMenu {

    private $url = null;
    private $access = null;
    private $returns = array(
        "state" => 0,
        "message" => ""
    );

    function __construct() {
        $this->access = getAccessToken(WEI_ID);
    }

    function create() {

        $this->url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $this->access;
        $data = array(
            "button" => array(
                array(
                    "type" => "click",
                    "name" => "摇一摇",
                    "key" => "YAOYIYAO"
                ),
                array(
                    "name" => "投票",
                    'sub_button' => array(
                        array(
                            "type" => "click",
                            "name" => "投票",
                            "key" => "TOUPIAO"
                        ),
                        array(
                            "type" => "scancode_waitmsg",
                            "name" => "扫一扫",
                            "key" => "SAOYISAO",
                            "sub_button" => '',
                        ),
                    ),
                ),
                array(
                    "type" => "view",
                    "name" => "关于我们",
                    "url" => "http://www.aixianxing.com"
                ),
            ),
        );

        $data = json_encode($data);
        $res = httpsPost($this->url, $data);
        if ($res) {
            $res = json_decode($res, true);
            //调用全局代码判断结果
            switch ($res["errcode"]) {
                case 0:
                    $this->returns['message'] = "菜单创建完毕,您可以重新关注来获取新的菜单。";
                    break;
                case 40018:
                    $this->returns['message'] = "菜单字段太长。";
                    $this->returns['state'] = "1";
                    break;
                case 48001:
                    $this->returns['message'] = "api功能未授权，请确认公众号已获得该接口，"
                            . "可以在公众平台官网-开发者中心页中查看接口权限。";
                    $this->returns['state'] = "1";
                    break;
                case 40014:
                    $this->returns['message'] = "不合法的access_token，"
                            . "请开发者认真比对access_token的有效性（如是否过期），"
                            . "或查看是否正在为恰当的公众号调用接口";
                    $this->returns['state'] = "1";
                    break;

                default:
                    $this->returns['message'] = "errcode:" . $res["errcode"] . "未知错误，请与管理员联系QQ:772321344";
                    $this->returns['state'] = "1";
                    break;
            }
        }
        echo json_encode($this->returns);
    }

}

$user = new UserMenu();
$user->create();
