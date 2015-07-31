<?php

/**
 * Description of Message
 * www.aixianxing.com
 * @author xiaxiaxia
 */
class Message {

    private $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>0</FuncFlag>
        </xml>";

    function textMessage($wxData, $wxContent) {
        return sprintf($this->textTpl, $wxData['fromUsername'], $wxData['toUsername'], $wxData['time'], "text", $wxContent);
    }

    function danTuWen($wxData, $title = "", $description = "", $imageUrl = "", $linkUrl = "") {
        $this->textTpl = "<xml>
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
        return sprintf($this->textTpl, $wxData['fromUsername'], $wxData['toUsername'], $wxData['time'], "news", $title, $description, $description, $linkUrl);
    }

}
