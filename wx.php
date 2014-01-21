<?php
//header("Content-type: text/html; charset=utf-8");

//include_once("wx_menu.php");//自定义菜单,订阅号用不了，只有服务号才能用

/**
  * wechat php test
  */

$wechatObj = new wechatMainMethod();
$wechatObj->responseMsg();

class wechatMainMethod
{
    public function responseMsg()
    {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//获取数据

      	//解析数据
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;//发送消息方ID
                $toUsername = $postObj->ToUserName;//接收消息方ID
				$form_MsgType = $postObj->MsgType;//消息类型
				$form_Content = $postObj->Content;//消息内容
                $keyword = trim($postObj->Content);//关键字
				$form_Event = $postObj->Event;//获取事件类型
				$form_Key=$postObj->EventKey;//获取菜单Key值
                $time = time();//时间
				$form_CreateTime = $postObj->CreateTime;//发送时间
                //$textTpl = $this->getconn(1);
				if($form_MsgType=="text")//文本类消息处理
				{
					if(!empty( $keyword ))//关键字
					{
						if($keyword=="tel"){
							$textTpl = $this->getconn(2);
						    $msgType = "text";
						    $contentStr = $time;
						    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						    echo $resultStr;
						    exit;
						}else{
							$textTpl = $this->getconn();
						    $msgType = "text";
						    $contentStr = $time;
						    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						    echo $resultStr;
						    exit;
						}
					}
				}
				if($form_MsgType=="event")//事件类消息处理（包含菜单）
				{
					if($form_Event=="CLICK")
					{
						if($form_Key=="about")
						{
						  $textTpl = $this->getconn(1);
						    $msgType = "text";
						    $contentStr = $time;
						    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						    echo $resultStr;
						    exit;
						}else if($form_Key=="contact"){
							$textTpl = $this->getconn(2);
						    $msgType = "text";
						    $contentStr = $time;
						    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						    echo $resultStr;
						    exit;
						}else{
							$textTpl = $this->getconn();
						    $msgType = "text";
						    $contentStr = $time;
						    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						    echo $resultStr;
						    exit;
						}
					}
					else if($form_Event=="subscribe")//关注
					{
						    $textTpl = $this->getconn();
						    $msgType = "text";
						    $contentStr = $time;
						    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						    echo $resultStr;
						    exit;
					}
				}		
        }else {
        	echo "";
        	exit;
        }
    }
	function getconn($a){
		switch ($a){
           case 1:
              $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[wfanr微帆科技是移动互联网平台开发与服务提供商，可提供APP定制开发、商城等移动互联网服务。]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
           break;  
           case 2:
              $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[TEL:4007888888]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
           break;
           default:
              $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
                            <ArticleCount>2</ArticleCount>
							<Articles>
                            <item>
                            <Title><![CDATA[wfanr 微帆科技 移动互联网平台开发与服务提供商]]></Title> 
                            <Description><![CDATA[wfanr微帆科技是移动互联网平台开发与服务提供商，可提供APP定制开发、商城等移动互联网服务。]]></Description>
                            <PicUrl><![CDATA[http://108.186.161.197/images/logo_320.jpg]]></PicUrl>
                            <Url><![CDATA[http://108.186.161.197]]></Url>
                            </item>
							<item>
                            <Title><![CDATA[wfanr 服装演示商店]]></Title> 
                            <Description><![CDATA[wfanr微帆科技是移动互联网平台开发与服务提供商，可提供APP定制开发、商城等移动互联网服务。]]></Description>
                            <PicUrl><![CDATA[http://108.186.161.197/images/logo_320.jpg]]></PicUrl>
                            <Url><![CDATA[http://108.186.161.197]]></Url>
                            </item>
                            </Articles>
							</xml>";
         }
		 return $textTpl;
	}
}
?>