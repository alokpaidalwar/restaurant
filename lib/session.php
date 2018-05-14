<?php
	require_once("db_functions.php");
	$db = new db();
	$user_check=$_SESSION['username'];
	$row=$db->getOne("SELECT * FROM users_info WHERE username='$user_check'");
	$user =$row['username'];
	
	if(!isset($user)){
			header('Location: index.php'); 
	}
?>