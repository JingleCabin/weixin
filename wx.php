<?php
//header("Content-type: text/html; charset=utf-8");

//include_once("wx_menu.php");//�Զ���˵�,���ĺ��ò��ˣ�ֻ�з���Ų�����

/**
  * wechat php test
  */

$wechatObj = new wechatMainMethod();
$wechatObj->responseMsg();

class wechatMainMethod
{
    public function responseMsg()
    {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//��ȡ����

      	//��������
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;//������Ϣ��ID
                $toUsername = $postObj->ToUserName;//������Ϣ��ID
				$form_MsgType = $postObj->MsgType;//��Ϣ����
				$form_Content = $postObj->Content;//��Ϣ����
                $keyword = trim($postObj->Content);//�ؼ���
				$form_Event = $postObj->Event;//��ȡ�¼�����
				$form_Key=$postObj->EventKey;//��ȡ�˵�Keyֵ
                $time = time();//ʱ��
				$form_CreateTime = $postObj->CreateTime;//����ʱ��
                //$textTpl = $this->getconn(1);
				if($form_MsgType=="text")//�ı�����Ϣ����
				{
					if(!empty( $keyword ))//�ؼ���
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
				if($form_MsgType=="event")//�¼�����Ϣ���������˵���
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
					else if($form_Event=="subscribe")//��ע
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
							<Content><![CDATA[wfanr΢���Ƽ����ƶ�������ƽ̨����������ṩ�̣����ṩAPP���ƿ������̳ǵ��ƶ�����������]]></Content>
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
                            <Title><![CDATA[wfanr ΢���Ƽ� �ƶ�������ƽ̨����������ṩ��]]></Title> 
                            <Description><![CDATA[wfanr΢���Ƽ����ƶ�������ƽ̨����������ṩ�̣����ṩAPP���ƿ������̳ǵ��ƶ�����������]]></Description>
                            <PicUrl><![CDATA[http://108.186.161.197/images/logo_320.jpg]]></PicUrl>
                            <Url><![CDATA[http://108.186.161.197]]></Url>
                            </item>
							<item>
                            <Title><![CDATA[wfanr ��װ��ʾ�̵�]]></Title> 
                            <Description><![CDATA[wfanr΢���Ƽ����ƶ�������ƽ̨����������ṩ�̣����ṩAPP���ƿ������̳ǵ��ƶ�����������]]></Description>
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