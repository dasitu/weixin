<?php
require 'db.php';
require 'func.php';

if (!empty($_POST['openId'])){
	$data = array(
		'carid'=> $_POST['carId'],
		'name' => $_POST['contactName'],
		'mobile'=> $_POST['tel'],
		'contributor_openid'=> $_POST['openId']
		);
	try {
		//var_dump($data);
		$affectedRecord = $db->insert('car',$data);
		echo "贡献成功";
		logging("贡献车牌 ".$data['carid']." 成功","INFOR");
	} catch (Exception $e) {
		echo "贡献失败，请联系Evan,He<BR>\n\n";
		logging($e->getMessage(),"ERROR");
		//print $e->getMessage();
	} 
}
else
	echo "不正确的访问";
?>
