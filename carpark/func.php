<?php
require_once "conf.php";

function logging($text,$level=DEFAULT_LOG_LEVEL,$logFile=LOG_FILE){
//Level definition: ERROR,DEBUG,INFOR

	date_default_timezone_set(DEFAULT_LOG_TIMEZONE);
	$date = date(DateTime::W3C);
	$fhandler = fopen($logFile,'a');
	
	$line = "[".$date."][".$level."]".$text."\n";
	fwrite($fhandler, $line);
	fclose($fhandler);
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

		logging("查询 $searchedCar","INFOR");

		$searchedCar = preg_replace('/\s(?=)/', '', $searchedCar);		
		$bind = array(
			":search" => "%$searchedCar%"
		);
		$cars = $dbconn->select("car", "carid LIKE :search", $bind);
		
		//var_dump($cars);
		//exit;
		$results = "没找到车牌号是 $searchedCar 的记录。".'<a href="reg.php?c='.$searchedCar.'&o='.$userOpenId.'">贡献车牌?</a>';
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
		logging("返回 ".str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $results),"INFOR");
		return trim($results,"\n");
}
?>