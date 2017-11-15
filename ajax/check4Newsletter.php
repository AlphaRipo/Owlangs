<?php require_once "db.php";

	$counter = "";
	global $db;
	if($stmt = $db->prepare("select count(*) from newsletters"))
	{
		$stmt->execute();
		$check = ( 100 - $stmt->fetchColumn() );
		$stmt->closeCursor();
		echo $check;
	}
?>