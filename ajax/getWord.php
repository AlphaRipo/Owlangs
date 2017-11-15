<?php require_once "db.php";

	global $db;
	if(isset($_POST['limit']) and isset($_POST['offset']))
	{
		$query = "select * from words order by id asc limit ".$_POST['limit']." offset ".$_POST['offset'];
		if($stmt = $db->prepare($query))
		{
			$stmt->execute();
			$word = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

			$query = "select count(*) from words"; 
			
			if($stmt = $db->prepare($query))
			{
				$stmt->execute();
				$max = $stmt->fetchColumn();
				$stmt->closeCursor();
			}

			echo json_encode(array("word"=>$word,"max"=>$max),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
		}
	}

?>