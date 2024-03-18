<?php 
	
	$path = "https://".$_SERVER['SERVER_NAME']."/";
	$host = 'localhost:3309';
	$user = 'root';
	$db = 'chatsys';
	$pwd = '';

	$conn = mysqli_connect($host, $user, $pwd, $db);

	// $sql = 'CREATE TABLE user_msg(
	// 	id INT(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	// 	chat_body VARCHAR(255) NOT NULL
	// 	)';
	// if($conn){
	// 	echo "connected";
	// }else{
	// 	echo 'not connected';
	// }

?>