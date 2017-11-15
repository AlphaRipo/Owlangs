<?php require_once "db.php";

	if(empty($_POST['mid'])) {
		$post = file_get_contents('php://input');
		$_POST = json_decode($post,true);
	}

	$word = $_POST['word'];
	$mid = $_POST['mid'];
	if($mid and $word)
	{
		global $db;
		if($word['id_my'] == $mid)
		{
			if($stmt = $db->prepare("delete from dict_my where id_dict = ? and id_my = ? "))
			{
				$stmt->bindValue(1, $word['id'], PDO::PARAM_INT);
				$stmt->bindValue(2, $mid, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->closeCursor();
			}
		}
	}

?>