﻿<?php
require_once "func.php";
require_once "db.php";

ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
define("TOKEN", "kaka");
//valid();

//get post data
$postStr = file_get_contents("php://input");

if(!empty($_GET['z']))
$postStr = '<xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[fromUser]]></FromUserName> 
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[A7]]></Content>
 <MsgId>1234567890123456</MsgId>
 </xml>';

//extract post data
if (!empty($postStr)){
	/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
	the best way is to check the validity of xml by yourself */
		libxml_disable_entity_loader(true);
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$msgType = $postObj->MsgType;
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		//keyword are difference according to the msgType
		if($msgType == "text"){
			$keyword = trim($postObj->Content);
		}
		else if($msgType == "voice"){
			$keyword = $postObj->Recognition;
		}
		
		$time = time();
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
		if(!empty( $keyword )){
			$msgType = "text";
			$contentStr = getCarNumber($keyword,$fromUsername,$db);
			//$contentStr = "Welcome ".$fromUsername." to wechat world!".$keyword;
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			echo $resultStr;
		}else{
			echo "Input something...";
		}
}else {
	echo "";
	exit;
}
?>