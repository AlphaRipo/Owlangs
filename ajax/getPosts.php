<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $pid = $_POST['pid'];
    $mid = $_POST['mid'];
    $vip = $_POST['vip'];
    $mode = $_POST['mode']; // 1 - timeline, 0 - wall

    if($pid > 0) { $moreThanPostNo = " and posts.id < :pid "; }
    if($mode > 0) { $onlyMyPosts = " and posts.kto = :mid4 "; }

    $help = " select posts.*, users.skype, users.avatar, users.nazwisko, users.imie, users.vip, users.lvl_ang from posts inner join users on posts.kto = users.id where ( posts.reach = 0 or 

        ( select if ( ( select count(*) from friends where ( friends.id_0 = :mid1 and posts.kto = friends.id_1 ) or posts.kto = :mid2 ) > 0 and posts.reach = 1, true, false ) ) or 
        ( select if ( posts.reach = 2 and :vip > 0, true, false ) ) or 
        ( select if ( posts.reach = 3 and posts.kto = :mid3, true, false ) ) 

        ) $moreThanPostNo $onlyMyPosts order by posts.id desc limit 50 ";

    global $db;
    if($stmt = $db->prepare($help))
    {
        $stmt->bindValue(':mid1',$mid,PDO::PARAM_INT);
        $stmt->bindValue(':vip',$mid,PDO::PARAM_INT);
        $stmt->bindValue(':mid2',$vip,PDO::PARAM_INT);
        $stmt->bindValue(':mid3',$mid,PDO::PARAM_INT);
        if($pid > 0) { $stmt->bindValue(':pid',$pid,PDO::PARAM_INT); }
        if($mode > 0) { $stmt->bindValue(':mid4',$mode,PDO::PARAM_INT); }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $arrays = [];

        foreach ($result as $i => $v)
        {
            $id = $v['id'];
            $date = $v['data'];

            if($v['attachments']) {
                $v['attachments'] = json_decode($v['attachments'], true);
                $result[$i]['attachments'] = $v['attachments'];
            }
            if($v['todo']) {
                $v['todo'] = json_decode($v['todo'], true);
                $result[$i]['todo'] = $v['todo'];
            }

            if($stmt = $db->prepare("select comments.*, users.avatar, users.nazwisko, users.imie, users.vip, users.lvl_ang from comments inner join users on comments.kto = users.id where gdzie = ? order by date asc "))
            {
                $stmt->bindValue(1,$id,PDO::PARAM_INT);
                $stmt->execute();
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                if($stmt = $db->prepare("select count(*) from likes where co = ? and kto = ?"))
                {
                    $stmt->bindValue(1,$id,PDO::PARAM_INT);
                    $stmt->bindValue(2,$mid,PDO::PARAM_INT);
                    $stmt->execute();
                    $liked = $stmt->fetchColumn();
                    $stmt->closeCursor();	
                }
                if($stmt = $db->prepare("select count(*) from likes where co = ?"))
                {
                    $stmt->bindValue(1,$id,PDO::PARAM_INT);
                    $stmt->execute();
                    $likes = $stmt->fetchColumn();
                    $stmt->closeCursor();
                }
            }
            $arrays[$i] = array_merge($v,['liked'=>$liked,'likes'=>$likes,'id'=>$id,'ts'=>strtotime($date),'comments'=>$comments]);
        }
        echo json_encode($arrays,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>