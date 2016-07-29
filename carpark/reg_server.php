<?php
require_once "conf.php";

if (!empty($_POST['openId'])){
	$data = array(
		'carid'=> $_POST['carId'],
		'name' => $_POST['contactName'],
		'mobile'=> $_POST['tel'],
		'contributor_openid'=> $_POST['openId']
		);
		//var_dump($data);
		if($db->insert('car',$data)){
			echo "贡献成功";
			logging("贡献成功 ".$data['carid'].' '.$data['mobile'].' by '.$data['contributor_openid'],"INFOR");
		}
		else
		{
			echo "贡献失败，请联系Evan,He<BR>\n\n";
			logging("贡献失败 ".var_export($data,true),"ERROR");
		}
}
else
	echo "不正确的访问";
?>
