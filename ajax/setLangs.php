<?php require_once "db.php";

	if(empty($_POST['mid'])) {
		$post = file_get_contents('php://input');
		$_POST = json_decode($post,true);
	}

	$word = $_POST['word'];
	$mid = $_POST['mid'];
	if($mid)
	{
		global $db;
		if($stmt = $db->prepare("update langs set pl = ?, en = ? where id = ?"))
		{
			$stmt->bindValue(1, trim($word['pl']), PDO::PARAM_STR);
			$stmt->bindValue(2, trim($word['en']), PDO::PARAM_STR);
			$stmt->bindValue(3, $word['id'], PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
		}
	}

?>