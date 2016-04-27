<?php

//Database connection
require 'db.php';

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
		
function valid(){
	$echoStr = $_GET["echostr"];
	//valid signature , option
	if($this->checkSignature()){
		echo $echoStr;
		exit;
	}
}

function checkSignature(){
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
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
}

function getCarNumber($searchedCar,$userOpenId,$dbconn)	{

		$searchedCar = preg_replace('/\s(?=)/', '', $searchedCar);		
		$bind = array(
			":search" => "%$searchedCar%"
		);
		$cars = $dbconn->select("car", "carid LIKE :search", $bind);
		
		//var_dump($cars);
		//exit;
		$results = "没找到车牌号是 $searchedCar 的记录。".'<a href="http://ebear.netai.net/weixin/reg.php?c='.$searchedCar.'&o='.$userOpenId.'">贡献车牌?</a>';
		if(!empty($cars)){
			$results = "";
			$limit = 3;
			for($i=0;$i<count($cars);$i++){
				$results .= $cars[$i]["carid"]."\n";
				
				if(!empty($cars[$i]["name"])){
					$results .= $cars[$i]["name"].", ";
				}
				
				$results .=	$cars[$i]["mobile"]."\n";
				
				if($i==($limit-1)){
					$results .= "找到超过 $limit 个匹配的车牌，只显示了前 $limit 个，多输点儿字嘛！"; 
					break;
				}
			}
		}
		return trim($results,"\n");
}
?>