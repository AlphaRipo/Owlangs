<?php require_once "db.php";

        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
	$mid = $_POST['mid'];
	$text = $_POST['text'];

	$keywords = array();
	$foundUsers = array();
	$foundTrainings = array();
	
	$trainings = array("id","name");
	$users = array("imie","nazwisko");
	$tempKeys = preg_split("/[\s\-\/]+/",trim(preg_replace('# +#', ' ', $text)));

	foreach ($tempKeys as $value) {
            if( strlen($value) > 1) array_push($keywords,$value);
	}
	
	// USERS
        
        global $db;
	$query = "select * from users where lower(concat(".implode(",",$users).")) regexp lower('".implode("|",$keywords)."')";
	if($stmt = $db->prepare($query))
	{
            $stmt->execute();
            $foundUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            foreach ($foundUsers as $k => $o) {
                $query = "select count(*) from friends where id_0 = ? and id_1 = ? ";
                if($stmt = $db->prepare($query)) {
                    $stmt->bindValue(1,$mid,PDO::PARAM_INT);
                    $stmt->bindValue(2,$o['id'],PDO::PARAM_INT);
                    $stmt->execute();
                    $isfriends = $stmt->fetchColumn();
                    $stmt->closeCursor();
                    $foundUsers[$k] = array_merge($foundUsers[$k],array("isfriends"=>$isfriends));
                }
            }
	}

	// TRAININGS

	$query = "select * from trainings where lower(concat(".implode(",",$trainings).")) regexp lower('".implode("|",$keywords)."')";
	if($stmt = $db->prepare($query))
	{
            $stmt->execute();
            $foundTrainings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($foundTrainings as $k => $v) {
                if($v['content']) {
                    $foundTrainings[$k]['content'] = json_decode($v['content'], true);
                }
            }
            foreach ($foundTrainings as $k => $v) {
                if($v['dict']) {
                    $foundTrainings[$k]['dict'] = json_decode($v['dict'], true);
                }
            }
            $stmt->closeCursor();
	}

	echo json_encode(array("users"=>$foundUsers,"trainings"=>$foundTrainings),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
?>