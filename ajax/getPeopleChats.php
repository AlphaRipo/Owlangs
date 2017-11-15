<?php require_once "db.php";
    
    if(empty($_POST['mid'])) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    $mid = $_POST['mid'];
        
    global $db;
    if($stmt = $db->prepare("select chats.kto, chats.komu from chats where chats.kto = ? or chats.komu = ? order by chats.kiedy desc"))
    {
        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
        $stmt->bindValue(2,$mid,PDO::PARAM_INT);
        $stmt->execute();
        $result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        foreach ($result1 as $key => $value) {
            if($value['kto'] !== $mid){
                $array[] = $value['kto'];
            }
            if($value['komu'] !== $mid){
                $array[] = $value['komu'];
            }
        }
        $array = array_unique($array);
        
        foreach ($array as $key => $value) {
            
            if($stmt = $db->prepare("select imie, nazwisko, id, lvl_ang, avatar from users where id = ? limit 1"))
            {
                $stmt->bindValue(1,$value,PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                if($user)
                { 
                    $id = $user['id'];
                    if($stmt = $db->prepare("select kto,komu,co,kiedy,seen from chats where (chats.kto = ? and chats.komu = ?) or (chats.kto = ? and chats.komu = ?) order by chats.kiedy desc limit 1"))
                    {
                        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
                        $stmt->bindValue(2,$id,PDO::PARAM_INT);
                        $stmt->bindValue(3,$id,PDO::PARAM_INT);
                        $stmt->bindValue(4,$mid,PDO::PARAM_INT);
                        $stmt->execute();
                        $lastest = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                        if($lastest) { 
                            $result2[] = array_merge($user, $lastest);
                        }
                        $stmt->closeCursor();
                    }
                }
                $stmt->closeCursor();
            }
        }
        
        echo json_encode($result2,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
 ?>