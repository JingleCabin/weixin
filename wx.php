<?php

define("TOKEN","weifan");
$wechatObj = new wechatCallbackapi();
$wechatObj->valid();

class wechatCallbackapi
{
    public function valid()
    {
        $echostr = $_GET['echostr'];

	if($this->checkSignature())
	{
	    echo $echostr;
	    exit;
	}

    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
	$timestamp = $_GET["timestamp"];
	$nonce = $_GET["nonce"];

	$token = TOKEN;
	$tmpArr = array($token,$timestamp,$nonce);
	sort($tmpArr);
	$tmpStr = implode($tmpArr);
	$tmpStr = sha1($tmpStr);

	if($tmpStr == $signature)
	{
	    return true;
	}else{
	    return false;
	}
    }
}
?>
