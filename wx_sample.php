<?php

error_reporting(0);
/**
 * wechat php test
 */
//define your token
define("TOKEN", "weixin");
include './includefiles.php';


$wechatObj = new wechatCallbackapiTest();

//$wechatObj->valid();

class wechatCallbackapiTest {

    public static $access_token = null;

    function __construct() {
        $this->getselfAccess_token();
        $this->valid();
    }

    function getselfAccess_token() {
        if (is_null(self::$access_token)) {
            self::$access_token = getAccessToken(WEI_ID);
        }
    }

    public function valid() {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if ($this->checkSignature()) {

            $this->responseMsg();

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
            $wxData['textTpl'] = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";

            //数据插入
            insertOpenId($wxData['fromUsername']);

            //事件处理
            if ($wxData['MsgType']) {
                switch ($wxData['MsgType']) {
                    case "text":
                        typeText($wxData);
                        break;
                    case "event":
                        $wxData['event'] = trim($postObj->Event);
                        typeEvent($wxData);
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

}

//function 
function sendMess() {
    
}

function yaoyiyao($wxData) {
    $textTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[%s]]></MsgType>
    <ArticleCount>1</ArticleCount>
    <Articles>
    <item>
    <Title><![CDATA[%s]]></Title> 
    <Description><![CDATA[%s]]></Description>
    <PicUrl><![CDATA[%s]]></PicUrl>
    <Url><![CDATA[%s]]></Url>
    </item>
    </Articles>
    </xml> ";
    return sprintf($textTpl, $wxData['fromUsername'], $wxData['toUsername'], $wxData['time'], "news", "摇一摇", "拿起你的手机一起来摇一摇", "http://mp.weixin.qq.com/wiki/static/assets/ac9be2eafdeb95d50b28fa7cd75bb499.png", $_SERVER['SERVER_NAME'] . "/html/shake.php?id=" . $wxData['fromUsername']);
}

function insertOpenId($openId) {
    if (empty($openId)) {
        return false;
    }
    $mydb = db::getInstance();
    //看是否有数据  

    $sql = "select p_id from weixin_attention where delated =0 and openid = '" . $openId . "'";
    $res = $mydb->selectOne($sql);
    if ($res) {//update
        $data = array(
            'update' => time(),
        );
        $mydb->update("weixin_attention", $data, "p_id = " . $res['p_id']);
    } else {//insert   username 需要  调用方法
        $data = array(
            'openid' => $openId,
            'username' => $openId,
            'created' => time(),
        );
        $mydb->insert("weixin_attention", $data);
    }
    return true;
}

function typeText($wxData) {
    if (!empty($wxData['keyword'])) {
        switch ($wxData['keyword']) {
            case "摇一摇":
                //发送图文消息
                $resultStr = yaoyiyao($wxData);
                break;
            case "投票":
                $resultStr = yaoyiyao($wxData);
                break;
            default:
                //其他文职消息， 可以推送给管理员
                $resultStr = textMessage($wxData, "感谢您的关注！不知道输什么？ 可以试试 摇一摇 \n即可参与游戏，输入：投票 \n即可为您心仪的小朋友投上一票");
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
            $resultStr = textMessage($wxData, "感谢您的关注！ 输入关键字：摇一摇 \n即可参与游戏，输入：投票 \n即可为您心仪的小朋友投上一票");
            break;
        case "unsubscribe":
            //t推送给管理员
            $wxData['fromUsername'] = "oC62huMMqGoRhQfwBqX3w_ukxuU4";
            $resultStr = textMessage($wxData, "感谢您的关注");
            break;
        case "CLICK":
            //自定义菜单的点击事件
            $wxData['EventKey'] = trim($wxData['postObj']->EventKey);
            eventClick($wxData);
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

function eventClick($wxData) {
//    $wxData['EventKey']   根据自定义菜单来判断
    switch ($wxData['EventKey']) {
        case 0:
            $resultStr = textMessage($wxData, "点击了 0 号菜单");
            break;
        case 1:
            $resultStr = textMessage($wxData, "点击了 1 号菜单");
            break;
        case 2:
            $resultStr = textMessage($wxData, "点击了 2 号菜单");
            break;

        default:
            break;

            echo $resultStr;
            exit;
    }
}

function textMessage($wxData, $wxContent) {
    return sprintf($wxData['textTpl'], $wxData['fromUsername'], $wxData['toUsername'], $wxData['time'], "text", $wxContent);
}

?>