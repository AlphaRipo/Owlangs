<?php require_once "db.php";

	$nr = $_POST['nr'];
	$mid = $_POST['mid'];

	global $db;
	if($stmt = $db->prepare("select count(*) from trainings_my where mid = ? and tid = ?"))
	{
		$stmt->bindValue(1, $mid, PDO::PARAM_INT);
		$stmt->bindValue(2, $nr, PDO::PARAM_INT);
		$stmt->execute();
		$check = $stmt->fetchColumn();
		$stmt->closeCursor();
		if($check > 0)
		{
			if($stmt = $db->prepare("delete from trainings_my where mid = ? and tid = ?"))
			{
				$stmt->bindValue(1, $mid, PDO::PARAM_INT);
				$stmt->bindValue(2, $nr, PDO::PARAM_INT);
				
                                $stmt->execute();
				$stmt->closeCursor();
				echo "ok";
			}
		}
	}

?>