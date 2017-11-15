<?php require_once "db.php";

	global $db;
	$query = " select * from langs order by id asc"; 
	if($stmt = $db->prepare($query))
	{
            $stmt->execute();
            $word = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            echo json_encode(array("word"=>$word),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
	}
?>