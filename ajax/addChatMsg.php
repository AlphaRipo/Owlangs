<?php require_once "db.php";

	$content = $_POST['content'];
	$mid = $_POST['mid'];
	$id = $_POST['id'];

	if($content and $mid and $id)
	{
		global $db;
		$now = date('Y-m-d H:i:s');
			
		if($stmt = $db->prepare("insert into chats set kto = ?, komu = ?, co = ?, kiedy = ?"))
		{
			$stmt->bindValue(1, $mid, PDO::PARAM_INT);
			$stmt->bindValue(2, $id, PDO::PARAM_INT);
			$stmt->bindValue(3, $content, PDO::PARAM_STR);
			$stmt->bindValue(4, $now, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
		} 
	}
?>