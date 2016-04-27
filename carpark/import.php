<?php
setlocale(LC_ALL, "en_US.UTF-8");
$file = 'data.csv';
if (($handle = fopen("$file", "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		echo "INSERT INTO car(carid,name,mobile) VALUES('".$data[0]."','".$data[1]."','".$data[2]."');\n"; 
		echo "<br>";
	}
	fclose($handle);
}
?>