<?php

	if(!isset($_SESSION)) { session_start(); } 
	if(isset($_SESSION['MY_ID'])) $your_id = $_SESSION['MY_ID']; else die('wrong id');

	require_once "db.php";

	$_DIR = "../img/avatar/".$your_id."/";
	$images = glob($_DIR . "back_*.*");
	foreach ($images as $image){ unlink($image); }

	global $db;
	if($stmt = $db->prepare(" update users set back = 'img/avatar/back.jpg' where id = ? ")) 
	{
		$stmt->bindValue(1, $your_id, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->closeCursor();
	}

?>