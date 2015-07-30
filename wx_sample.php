<?php

/**
 * wechat php test
 */
//define your token
define("TOKEN", "weixin");
// $weixinData=array();
include './includefiles.php';
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

class wechatCallbackapiTest {

    public function valid() {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;


            file_put_contents("./wx_sam.txt", $echoStr);
            $this->responseMsg();
//            file_put_contents("./wx_samresponseMsg.txt", $echoStr);


            exit;
        }
    }

    public function responseMsg() {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        file_put_contents("./wx_samresponseMsg.txt", json_encode($GLOBALS));
        file_put_contents("./wx_samresponseMsgpostStr.txt", json_encode($postStr));

        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
              the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $wxData = array();

            $wxData['fromUsername'] = $postObj->FromUserName;
            $wxData['toUsername'] = $postObj->ToUserName;
            $wxData['keyword'] = trim($postObj->Content);
            $wxData['MsgType'] = trim($postObj->MsgType);
            $wxData['time'] = time();
            $contentStr = "moren";
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            
            //数据插入
            insertOpenId($wxData['fromUsername']);
            if (!empty($wxData['keyword'])) {
                //最好是用$MsgType来判断， f否则有可能无法处理用户的其他输入

                switch ($wxData['keyword']) {
                    case "摇一摇":
                        //发送图文消息
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

                        $resultStr = sprintf($textTpl, $wxData['fromUsername'], $wxData['toUsername'], $wxData['time'], "news", "摇一摇", "拿起你的手机一起来摇一摇", "http://mp.weixin.qq.com/wiki/static/assets/ac9be2eafdeb95d50b28fa7cd75bb499.png", $_SERVER['SERVER_NAME'] . "/html/shake.php?id=" . $wxData['fromUsername']);
                        echo $resultStr;
//                        exit;
                        break;
                    case "投票":
                        $contentStr = "投票";
                        $resultStr = sprintf($textTpl, $wxData['fromUsername'], $wxData['toUsername'], $wxData['time'], $wxData['msgType'], $contentStr);
                        echo $resultStr;
                        exit;
                        break;
                    default:
                        break;
                }



                $wxData['msgType'] = "text";
                $contentStr = "Welcome to wechat world!您的输入类型为：" . $wxData['msgType'] . $wxData['keyword']
                        . "-11--" . $wvData['fromUsername'];
            } else {
                $contentStr = "Welcome to wechat world!您的输入类型为：" . $wxData['msgType'] . $wxData['keyword']
                        . "-22--" . $wvData['fromUsername'];
            }
            $resultStr = sprintf($textTpl, $wxData['fromUsername'], $wxData['toUsername'], $wxData['time'], $wxData['msgType'], $contentStr);
            echo $resultStr;
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

function insertOpenId($openId) {
    if (empty($openId)) {
        return false;
    }
    $mydb = new mysql();
    //看是否有数据  

    $sql = "select p_di from weixin_attention where delated =0 and openid = '" . $openId . "'";
    $res = $mydb->execute($sql);
    $res = $mydb->fetch_assoc($res);
    if ($res) {//update
        $data = array(
            'update' => time(),
        );
        $mydb->update("weixin_attention", $data, "p_id = " . $res[0]['p_id']);
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

?>