<?php require_once "db.php";

	$post = file_get_contents('php://input');
	$_POST = json_decode($post,true);

	$auction = $_POST['auction'];

	global $db;
	if($stmt = $db->prepare("select auctions_offers.*, auctions.user, users.imie, users.nazwisko, users.lvl_ang from auctions_offers inner join users on users.id = auctions_offers.who inner join auctions on auctions.id = auctions_offers.auction where auctions_offers.auction = ? order by auctions_offers.term"))
	{
		$stmt->bindValue(1,$auction,PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
	}
?>