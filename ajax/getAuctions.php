<?php require_once "db.php";

	$post = file_get_contents('php://input');
	$_POST = json_decode($post,true);

	$mode = $_POST['mode'];
	$mid = $_POST['mid'];
	$where = '';

	if($mode == 'all') { $where = 'order by date desc'; }
	elseif($mode == 'me') { $where = 'where user = '.$mid.' order by date desc'; }
	elseif($mode == 'offer') { $where = 'where category = 2 order by date desc'; }
	elseif($mode == 'todo') { $where = 'where category = 1 order by date desc'; }

	global $db;
	if($stmt = $db->prepare("select auctions.*, users.imie, users.nazwisko, users.lvl_ang from auctions INNER JOIN users ON users.id = auctions.user ".$where)) // order by date desc
	{
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
	}
?>