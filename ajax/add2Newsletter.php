<?php require_once "db.php";

	$val = $_POST['val'];
	$counter = "";
	$status = "";
	if($val)
	{
		global $db;
		if($stmt = $db->prepare("select count(*) from newsletters where email = ?"))
		{
			$stmt->bindValue(1, $val, PDO::PARAM_STR);
			$stmt->execute();
			$check = $stmt->fetchColumn();
			$stmt->closeCursor();
			if($check == 0)
			{
				if($stmt = $db->prepare("insert into newsletters set email = ?"))
				{
					$stmt->bindValue(1, $val, PDO::PARAM_STR);
					$stmt->execute();
					$stmt->closeCursor();
					$status = "added";

					if($stmt = $db->prepare("select count(*) from newsletters"))
					{
						$stmt->execute();
						$counter = ( 100 - $stmt->fetchColumn() );
						$stmt->closeCursor();
					}
				}
			}
			else $status = "exist";
			echo json_encode(array("status"=>$status,"counter"=>$counter),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
		}
	}
?>