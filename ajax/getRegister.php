<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $what = $_POST['what'];
    $me = $_POST['me'];
    $limit = ($_POST['limit']) ? " limit ".$_POST['limit'] : "";
    
    $whomZero = "'%{\"user\":{\"id\":\"0\",\"seen\":\"0\"}}%'";
    $whom = "'%{\"user\":{\"id\":\"$me\",\"seen\":\"0\"}}%'";
    $whomQuery = "(( select if ((( select count(id) from friends where friends.id_0 = ? and friends.id_1 = register.who ) > 0 ), true, false ) and register.whom like $whom ) or register.whom like $whomZero )";

    if($me)
    {
        global $db;
        if($stmt = $db->prepare(" select count(id) as cc from register where register.what = ? and $whomQuery"))
        {
            $stmt->bindValue(1, $what, PDO::PARAM_STR);
            $stmt->bindValue(2, $me, PDO::PARAM_INT);
            $stmt->execute();
            
            $count = $stmt->fetchColumn();
            $stmt->closeCursor();
            
            if($count > 0) {
                if($stmt = $db->prepare(" select * from register where register.what = ? and $whomQuery order by register.id desc $limit"))
                {
                    $stmt->bindValue(1, $what, PDO::PARAM_STR);
                    $stmt->bindValue(2, $me, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($items as $i => $item) {
                        
                        $item['whom'] = json_decode($item['whom'], true);
                        
                        if($stmt = $db->prepare(" select (select count(*) from friends where (friends.id_0 = ? and friends.id_1 = users.id)) as friends, users.imie, users.nazwisko, users.avatar, users.lvl_ang from users where users.id = ? limit 1 "))
                        {
                            $stmt->bindValue(1, $me, PDO::PARAM_INT);
                            $stmt->bindValue(2, $item['who'], PDO::PARAM_INT);
                            $stmt->execute();

                            $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                            $stmt->closeCursor();
                            
                            $items[$i] = array_merge($item,$user);
                        }
                    }
                    $stmt->closeCursor();
                    
                }
            } 
            echo json_encode(["count"=>$count,"items"=>$items],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        }
    }

?>