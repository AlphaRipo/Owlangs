<?php require_once "db.php";

        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);

	$who = $_POST['mid'];
	$id = $_POST['nr'];

	global $db;
	if($stmt = $db->prepare("select count(*) from trainings where who = ? and id = ?"))
	{
            $stmt->bindValue(1, $who, PDO::PARAM_STR);
            $stmt->bindValue(2, $id, PDO::PARAM_STR);
            $stmt->execute();
            $check = $stmt->fetchColumn();
            $stmt->closeCursor();
            if($check > 0) { echo "ok"; }
            else { echo "no"; }
	}
?>