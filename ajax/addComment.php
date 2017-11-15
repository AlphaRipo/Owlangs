<?php require_once "db.php";

        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
        
	$now = date('Y-m-d H:i:s');        
	$uid = $_POST['uid'];
	$tresc = $_POST['tresc'];
	$gdzie = $_POST['gdzie'];
	$kto = $_POST['kto'];
	
	global $db;
	$stmt = $db->prepare("select count(id) from posts where id = ?");
	$stmt->bindValue(1, $gdzie, PDO::PARAM_STR);
	$stmt->execute();
	$pid =  $stmt->fetchColumn();
	$stmt->closeCursor();

	if($gdzie and $tresc and $pid > 0)
	{
            if($stmt = $db->prepare("insert into comments set kto = ?, tresc = ?, date = ?, gdzie = ?, cv = 0"))
            {
                $stmt->bindValue(1, $kto['id'], PDO::PARAM_INT);
                $stmt->bindValue(2, $tresc, PDO::PARAM_STR);
                $stmt->bindValue(3, $now, PDO::PARAM_STR);
                $stmt->bindValue(4, $gdzie, PDO::PARAM_INT);

                $check = $stmt->execute();
                $stmt->closeCursor();

                $cid = $db->lastInsertId();

                if($check)
                {
                    $whom = "'[{\"user\":{\"id\":\"$uid\",\"seen\":\"0\"}}]'";
                    
                    if($stmt = $db->prepare("insert into register set what = 'E', type = 'C', who = ?, whom = $whom, link = ?, sublink = ?, added = ?"))
                    {
                        $stmt->bindValue(1, $kto['id'], PDO::PARAM_INT);
                        $stmt->bindValue(2, $gdzie, PDO::PARAM_INT);
                        $stmt->bindValue(3, $cid, PDO::PARAM_INT);
                        $stmt->bindValue(4, $now, PDO::PARAM_STR);
                        $stmt->execute();
                        $stmt->closeCursor();
                    } 
                    $ret = [
                        "gdzie"=>$gdzie,
                        "tresc"=>$tresc,
                        "kto"=>$kto['id'],
                        "cv"=>0,
                        "id"=>$cid,
                        "date"=>$now,
                        "vip"=>$kto['vip'],
                        "nazwisko"=>$kto['nazwisko'],
                        "imie"=>$kto['imie'],
                        "lvl_ang"=>$kto['lvl_ang'],
                        "avatar"=>$kto['avatar']
                    ];
                    echo json_encode($ret,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
                }
            }
	}
?>