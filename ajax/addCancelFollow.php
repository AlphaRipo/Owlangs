<?php require_once "db.php";

    if(empty($_POST['mid'])) {
            $post = file_get_contents('php://input');
            $_POST = json_decode($post,true);
    }
    $mode = $_POST['mode'];
    $user = $_POST['user'];
    $index = $_POST['index'];
    $mid = $_POST['mid'];

    global $db;

    if($mode == 'insert') {
        
        $stmt = $db->prepare("select count(*) from friends where id_0 = ? and id_1 = ?");
        $stmt->bindValue(1, $mid, PDO::PARAM_INT);
        $stmt->bindValue(2, $user, PDO::PARAM_INT);
        $stmt->execute();
        $res =  $stmt->fetchColumn();
        $stmt->closeCursor();

        if($res == 0)
        {
            if($stmt = $db->prepare("insert into friends set id_0 = ?, id_1 = ?, since = ?"))
            {
                $dateFollowing = date('Y-m-d H:i:s');
                $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                $stmt->bindValue(2, $user, PDO::PARAM_INT);
                $stmt->bindValue(3, $dateFollowing, PDO::PARAM_STR);

                if($stmt->execute()) {
                    
                    $whom = "'[{\"user\":{\"id\":\"$user\",\"seen\":\"0\"}}]'";
                    
                    if($stmt = $db->prepare(" insert into register set what = 'F', type = 'F', who = ?, whom = $whom, link = ?, added = ? "))
                    {
                        $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                        $stmt->bindValue(2, $mid, PDO::PARAM_INT);
                        $stmt->bindValue(3, $dateFollowing, PDO::PARAM_STR);
                        $stmt->execute();
                    }
                }
                $stmt->closeCursor();
            }
        }
        
    } else if($mode == 'delete') {
        
        if($stmt = $db->prepare("delete from friends where id_0 = ? and id_1 = ?"))
        {
            $stmt->bindValue(1, $mid, PDO::PARAM_INT);
            $stmt->bindValue(2, $user, PDO::PARAM_INT);

            if($stmt->execute()){ 

                $whom = "'%{\"user\":{\"id\":\"$user\",\"seen\":%'";
                
                if($stmt = $db->prepare(" delete from register where what = 'F' and type = 'F' and who = ? and whom like $whom and link = ? "))
                {
                    $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                    $stmt->bindValue(2, $mid, PDO::PARAM_INT);
                    if($stmt->execute()) { echo $index; }
                    $stmt->closeCursor();
                }
            }
            $stmt->closeCursor();
        }
    }

?>