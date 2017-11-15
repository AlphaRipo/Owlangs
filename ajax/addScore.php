<?php require_once "db.php";

	$points = $_POST['points'];
	$mode = $_POST['mode'];
	$mid = $_POST['mid'];

	if($mode == 1) $field = "scTrain";
	elseif($mode == 2) $field = "scHelp";
	elseif($mode == 3) $field = "scTranslate";

	if($points and $field and $mid)
	{
		global $db;
		$query = " update users SET $field = $field + $points WHERE id = ? ";
		if($stmt = $db->prepare($query))
		{
			$stmt->bindValue(1, $mid, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
		}
	}

?>