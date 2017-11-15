<?php require_once "db.php";

	$mid = $_POST['mid'];
	$json = $_POST['json'];
	if($json) { foreach ($json as $i => $v) { go($v['id'],$mid); } }

	function go($id,$mid)
	{
		global $db;

		if($stmt = $db->prepare("select count(*) from dict_my where id_my = ? and id_dict = ?"))
		{
			$stmt->bindValue(1, $mid, PDO::PARAM_INT);
			$stmt->bindValue(2, $id, PDO::PARAM_INT);
			$stmt->execute();
			$check = $stmt->fetchColumn();
			$stmt->closeCursor();
			if($check == 0)
			{
				if($stmt = $db->prepare("insert into dict_my set id_my = ?, id_dict = ?"))
				{
					$stmt->bindValue(1, $mid, PDO::PARAM_INT);
					$stmt->bindValue(2, $id, PDO::PARAM_INT);
					$stmt->execute();
					$stmt->closeCursor();
				}
			}
		}
	}

?>