<?php
require 'mysql.php';

if (!empty($_POST['openId'])){
	$data = array(
		'carid'=> $_POST['carId'],
		'name' => $_POST['contactName'],
		'mobile'=> $_POST['tel'],
		'contributor_openid'=> $_POST['openId']
		);
	try {
		//var_dump($data);
		$affectedRecord = $mysql->insert('car',$data);
		echo "贡献成功";
	} catch (Exception $e) {
		echo "贡献失败，请联系Evan,He<BR>\n\n";	
		print $e->getMessage();   
	} 
}
else
	echo "不正确的访问";
?>