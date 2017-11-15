<?php require_once "db.php";

	$mid = $_POST['mid'];
	$id = $_POST['id'];

	global $db;
	if($mid and $id)
	{
		if($stmt = $db->prepare("select * from users where id = ?"))
		{
			$stmt->bindValue(1,$mid,PDO::PARAM_INT);
			$stmt->execute();
			$res = $stmt->fetch();
			$stmt->closeCursor();
			$imieKto = $res['imie'];
			$avatarKto = $res['avatar'];
			$nazwiskoKto = $res['nazwisko'];
		}

		if($stmt = $db->prepare("select * from users where id = ?"))
		{
			$stmt->bindValue(1,$id,PDO::PARAM_INT);
			$stmt->execute();
			$res = $stmt->fetch();
			$stmt->closeCursor();
			$imieKomu = $res['imie'];
			$avatarKomu = $res['avatar'];
			$nazwiskoKomu = $res['nazwisko'];
                        $level = $res['lvl_ang'];
		}

		if($stmt = $db->prepare("select * from chats where (kto = ? and komu = ?) or (komu = ? and kto = ?) order by kiedy"))
		{
			$stmt->bindValue(1,$mid,PDO::PARAM_INT);
			$stmt->bindValue(2,$id,PDO::PARAM_INT);
			$stmt->bindValue(3,$mid,PDO::PARAM_INT);
			$stmt->bindValue(4,$id,PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			$chats = null;

			foreach ($result as $i => $v)
			{   
                                $result[$i]['images'] = $v['images'] = json_decode($v['images'], true);
				$chats[$i] = array('id'=>$v['id'],'kto'=>$v['kto'],'komu'=>$v['komu'],'co'=>$v['co'],'kiedy'=>$v['kiedy'],'images'=>$v['images'],'seen'=>$v['seen']);
			}
			$users = array('level'=>$level,'imieKto'=>$imieKto,'nazwiskoKto'=>$nazwiskoKto,'imieKomu'=>$imieKomu,'nazwiskoKomu'=>$nazwiskoKomu,'avatarKto'=>$avatarKto,'avatarKomu'=>$avatarKomu);
			echo json_encode(array("chats"=>$chats,"users"=>$users),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
		}
	}
?>