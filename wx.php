<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weifan");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$msgType = trim($postObj->MsgType);
				switch($msgType) 
				{
					case "text":
						$resultStr = $this->handleText($postObj);
						break;
					case "event":
						$resultStr = $this->handleEvent($postObj);
						break;
					default:
						$reusltStr = "Unknow msg type:".$msgType;
						break;
				}
        }else {
        	echo "";
        	exit;
        }
    }
		
	// �����ı���Ϣ
	private function handleText($postObj) 
	{
		$keyword = trim($postObj->Content);        
		if(!empty( $keyword ))
		{
			$contentStr = "Welcome to wechat world!";
		}else{
			$contentStr = "Input something...";
		}
        $resultStr = $this->responseText($postObj, $contentStr);
        return $resultStr;
	}

	// �����¼���subscribe��unsubscribe
	private function handleEvent($object)
	{
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "��л����ע��΢���Ƽ������˺š�"."\n"."΢�źţ�gh_a6a2f98e3c9c"."\n"."΢���Ƽ���Ϊ���ṩ�人��������ָ�ϣ������Ϣ��ѯ������õı���΢���������ƽ̨��"."\n"."Ŀǰƽ̨�������£�"."\n"."��1�� �������������룺����"."\n"."��2�� �鹫���������룺����178"."\n"."��3�� ���룬�����룺����I love you"."\n"."��4�� ��Ϣ��ѯ�������룺������"."\n"."�������ݣ������ڴ�...";
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
        $resultStr = $this->responseText($object, $contentStr);
        return $resultStr;
	}

    private function responseText($object, $content, $flag=0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }

	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>