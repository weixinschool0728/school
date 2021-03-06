<?php

/**
 * wechat php test
 */
//define your token
define("TOKEN", "weixin");
include './includefiles.php';
include "./weixin/Message.php";
include "./weixin/UserInfo.php";
$wechatObj = new wechatCallbackapiTest();

class wechatCallbackapiTest {

    private $message = null;
    private $accessToken = null;
    private $openid = null;
    private $userInfo = null;

    function __construct() {
        $this->accessToken = getAccessToken();
        $this->message = new Message();
        $this->userInfo = new UserInfo($this->accessToken);

        $this->valid();
    }

    public function valid() {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;

            $this->responseMsg();
//            file_put_contents("./wx_samresponseMsg.txt", $echoStr);


            exit;
        }
    }

    public function responseMsg() {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
              the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $wxData = array();
            $wxData['postObj'] = $postObj;
            $wxData['fromUsername'] = $postObj->FromUserName;
            $wxData['toUsername'] = $postObj->ToUserName;
            $wxData['keyword'] = trim($postObj->Content);
            $wxData['MsgType'] = trim($postObj->MsgType);
            $wxData['time'] = time();
            $contentStr = "";
            $this->openid = $wxData['fromUsername'];


            //事件处理
            if ($wxData['MsgType']) {
                switch ($wxData['MsgType']) {
                    case "text":
                        $this->typeText($wxData);
                        break;
                    case "event":
                        $wxData['event'] = trim($postObj->Event);
                        $this->typeEvent($wxData);
                        break;
                    default:
                        break;
                }
            }
        } else {
            echo "";
            exit;
        }
    }

    function typeText($wxData) {
        if (!empty($wxData['keyword'])) {
            switch ($wxData['keyword']) {
                case "摇一摇":
                    //发送图文消息
                    //数据插入e
                    $this->insertOpenId($wxData['fromUsername']);
                    $resultStr = $this->message->danTuWen($wxData, "摇一摇", "一起摇吧", "https://mmbiz.qlogo.cn/mmbiz/uFNEVPHibdR13mCOhfRnq15RSt5oKRmgFkeY2Bnviav7zO7yRgpnU74RYlaG8kUmr4lAuw4cq3CA1RDe4DcfcCFg/0?wx_fmt=png", $_SERVER['SERVER_NAME'] . "/html/shake.php?id=" . $wxData['fromUsername']);
                    break;
                case "投票":
                    //数据插入e
                    $this->insertOpenId($wxData['fromUsername']);
                    $resultStr = $this->message->danTuWen($wxData, "投票", "为您心仪的小朋友加加油", $_SERVER['SERVER_NAME'] . "/html/img/yaoyiyao.png", $_SERVER['SERVER_NAME'] . "/html/shake.php?id=" . $wxData['fromUsername']);
                    break;
                case "扫一扫":

                    $resultStr = $this->message->danTuWen($wxData, "扫一扫", "一起来扫扫吧", $_SERVER['SERVER_NAME'] . "/html/img/yaoyiyao.png", $_SERVER['SERVER_NAME'] . "/html/shake.php?id=" . $wxData['fromUsername']);
                    break;
                case "js":
                    $resultStr = $this->message->danTuWen($wxData, "js接口", "一起来扫扫吧", $_SERVER['SERVER_NAME'] . "/html/img/yaoyiyao.png", $_SERVER['SERVER_NAME'] . "/html/jsDemo.php?id=" . $wxData['fromUsername']);
                    break;
                default:
                    //其他文职消息， 可以推送给管理员
                    $resultStr = $this->message->textMessage($wxData, "感谢您的关注！不知道输什么？ 可以试试 摇一摇 \n即可参与游戏，输入：投票 \n即可为您心仪的小朋友投上一票");
                    break;
            }
            echo $resultStr;
            exit;
        }
    }

    function typeEvent($wxData) {
        switch ($wxData['event']) {
            case "subscribe":
                //发送图文消息
                $resultStr = $this->message->textMessage($wxData, "感谢您的关注！ 输入关键字：摇一摇 \n即可参与游戏，输入：投票 \n即可为您心仪的小朋友投上一票");
                break;
            case "unsubscribe":
                //更新数据库的delated字段为1
                $mydb = db::getInstance();
                $data = array('delated' => 1, "updated" => time());
                $mydb->update("weixin_attention", $data, "openid='{$this->openid}'");
                $resultStr = $this->message->textMessage($wxData, "感谢您的关注");
                break;
            case "CLICK":
                //自定义菜单的点击事件
                $wxData['EventKey'] = trim($wxData['postObj']->EventKey);
                $this->eventClick($wxData);
                break;
            case "scancode_waitmsg":
                //自定义菜单的扫码事件
                $wxData['EventKey'] = trim($wxData['postObj']->EventKey);
                $this->eventscancodeWaitmsg($wxData);
                break;
            case "LOCATION":
                //自定义菜单的扫码事件
                $wxData['Latitude'] = trim($wxData['postObj']->Latitude);
                $wxData['Longitude'] = trim($wxData['postObj']->Longitude);
                $wxData['Precision'] = trim($wxData['postObj']->Precision);
                $resultStr = $this->message->textMessage($wxData, "X:".$wxData['Latitude']."Y:".$wxData['Longitude']."精度：".$wxData['Precision']);
                break;
            case "VIEW":
                //自定义菜单的视图连接事件  主要是    获取openId
//            $wxData['EventKey'] = trim($wxData['postObj']->EventKey);
//            eventClick($wxData);  
                break;
            default:
                //其他文职消息， 可以推送给管理员
                break;
        }
        echo $resultStr;
        exit;
    }

    function eventscancodeWaitmsg($wxData) {
//    $wxData['EventKey']   根据自定义菜单来判断
        $ScanCodeInfo = $wxData['postObj']->ScanCodeInfo;
        $ScanResult = $ScanCodeInfo->ScanResult;
        switch ($wxData['EventKey']) {
            case "SAOYISAO":
                if (preg_match("/^(.*)(aixianxing)(.*)$/i", $ScanResult)) {
                    if (preg_match("/^(.*)(php)$/i", $ScanResult)) {
                        //数据插入e
                        $this->insertOpenId($wxData['fromUsername']);
                        $resultStr = $this->message->danTuWen($wxData, "扫一扫", "没事儿就扫一扫", "https://mmbiz.qlogo.cn/mmbiz/uFNEVPHibdR13mCOhfRnq15RSt5oKRmgFkeY2Bnviav7zO7yRgpnU74RYlaG8kUmr4lAuw4cq3CA1RDe4DcfcCFg/0?wx_fmt=png", $ScanResult . "?opid=" . $this->openid);
                    } else {
                        $resultStr = $this->message->danTuWen($wxData, "扫一扫", "没事儿就扫一扫", "https://mmbiz.qlogo.cn/mmbiz/uFNEVPHibdR13mCOhfRnq15RSt5oKRmgFkeY2Bnviav7zO7yRgpnU74RYlaG8kUmr4lAuw4cq3CA1RDe4DcfcCFg/0?wx_fmt=png", $ScanResult . "&opid=" . $this->openid);
                    }
                } else {
                    $resultStr = $this->message->textMessage($wxData, $ScanResult);
                }
                break;
            case "":
                $resultStr = $this->message->textMessage($wxData, ScanResult);
                break;

            default:
                $resultStr = $this->message->textMessage($wxData, ScanResult);
                break;
        }
        echo $resultStr;
        exit;
    }

    function eventClick($wxData) {
//    $wxData['EventKey']   根据自定义菜单来判断
        switch ($wxData['EventKey']) {
            case "YAOYIYAO":
                //数据插入e
                $this->insertOpenId($wxData['fromUsername']);
                $resultStr = $this->message->danTuWen($wxData, "摇一摇", "一起摇吧", "https://mmbiz.qlogo.cn/mmbiz/uFNEVPHibdR13mCOhfRnq15RSt5oKRmgFkeY2Bnviav7zO7yRgpnU74RYlaG8kUmr4lAuw4cq3CA1RDe4DcfcCFg/0?wx_fmt=png", $_SERVER['SERVER_NAME'] . "/html/shake.php?id=" . $wxData['fromUsername']);
                break;
            case "TOUPIAO":
                //数据插入e
                $this->insertOpenId($wxData['fromUsername']);
                $resultStr = $this->message->danTuWen($wxData, "投票", "为你喜欢的小伙伴投上一票吧，", "https://mmbiz.qlogo.cn/mmbiz/uFNEVPHibdR13mCOhfRnq15RSt5oKRmgFkeY2Bnviav7zO7yRgpnU74RYlaG8kUmr4lAuw4cq3CA1RDe4DcfcCFg/0?wx_fmt=png", $_SERVER['SERVER_NAME'] . "/html/pointlike.php?opid=" . $this->openid);
                break;
            case 2:
                $resultStr = $this->message->textMessage($wxData, "点击了 2 号菜单");
                break;

            default:
                $resultStr = $this->message->textMessage($wxData, "竟然没有你要的选项？");
                break;
        }
        echo $resultStr;
        exit;
    }

    private function checkSignature() {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    function insertOpenId($openId) {
        if (empty($openId)) {
            return false;
        }
        $mydb = db::getInstance();
        //看是否有数据  

        $sql = "select p_id from weixin_attention where openid = '" . $openId . "'";
        $res = $mydb->selectOne($sql);
        if ($res) {//update
            $data = array(
                'updated' => time(),
                'delated' => 0,
            );
            $mydb->update("weixin_attention", $data, "p_id = " . $res['p_id']);
        } else {//insert   username 需要  调用方法
            $user = $this->userInfo->getUserInfo($openId);
            $data = array(
                'openid' => $openId,
                'username' => $user['nickname'],
                'p_head' => $user['headimgurl'],
                'created' => time(),
            );
            $mydb->insert("weixin_attention", $data);
        }
        return true;
    }

}

//function 
?>