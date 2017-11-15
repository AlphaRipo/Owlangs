<?php require_once "db.php";

	if(empty($_POST['mid'])) {
		$post = file_get_contents('php://input');
		$_POST = json_decode($post,true);
	}
        $mid = $_POST['mid'];

	global $db;
        
	$query = " select distinct(kto), users.imie, users.nazwisko, users.id, users.lvl_ang, users.avatar from chats inner join users on users.id = chats.kto where seen = 0 and komu = ? and kto <> ? order by kiedy desc"; 
	if($stmt = $db->prepare($query))
	{
		$stmt->bindValue(1, $mid, PDO::PARAM_INT);
		$stmt->bindValue(2, $mid, PDO::PARAM_INT);
		$stmt->execute();
                $count = $stmt->rowCount();
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
	}
        if(count($users) > 0)
        {    
            $query = " select count(id) from users where id = ? and available = 1"; 
            if($stmt = $db->prepare($query))
            {
                $stmt->bindValue(1, $users[0]['id'], PDO::PARAM_INT);
                $stmt->execute();
                $available = $stmt->fetchColumn();
                $stmt->closeCursor();
            }
        }
        echo json_encode(array("count"=>$count,'users'=>$users,'available'=>$available),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
                
?>