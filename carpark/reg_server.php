<?php
require_once "db.php";
require_once "func.php";

if (!empty($_POST['openId'])){
	$data = array(
		'carid'=> $_POST['carId'],
		'name' => $_POST['contactName'],
		'mobile'=> $_POST['tel'],
		'contributor_openid'=> $_POST['openId']
		);
		//var_dump($data);
		$affectedRecord = $db->insert('car',$data);
		if($affectedRecord==1){
			echo "贡献成功";
			logging("贡献成功 ".$data['carid'],"INFOR");
		}
		else
		{
			echo "贡献失败，请联系Evan,He<BR>\n\n";
		}
}
else
	echo "不正确的访问";
?>
