<?php require_once "db.php";

	global $db;
	$mid = $_POST['mid'];
	$limit = $_POST['limit'];

	$query = " select * from dict_my inner join dict on dict.id = dict_my.id_dict where dict_my.id_my = ? order by rand() limit " . $limit;
	
	if($stmt = $db->prepare($query))
	{
		$stmt->bindValue(1, $mid, PDO::PARAM_INT);
		$stmt->execute();
		$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
	}
	echo json_encode($words,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
?>