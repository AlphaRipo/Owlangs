<?php require_once "db.php";

	global $db;
	if(isset($_POST['object']) and isset($_POST['id']))
	{
		$query = "update words set audio = ? where word = ? and id = ?";
		if($stmt = $db->prepare($query))
		{
			$stmt->bindValue(1, json_encode( $_POST['object']['audio'], JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
			$stmt->bindValue(2, $_POST['object']['word'], PDO::PARAM_STR);
			$stmt->bindValue(3, $_POST['id'], PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
			echo "ok";
		}
	}

?>