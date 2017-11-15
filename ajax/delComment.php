<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $id = $_POST['id'];
    $mid = $_POST['mid'];
    $uid = $_POST['uid'];
    $pid = $_POST['pid'];
    $index = $_POST['index'];

    if($stmt = $db->prepare("delete from comments where id = ? and kto = ?"))
    {
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->bindValue(2, $mid, PDO::PARAM_INT);

        if($stmt->execute()) {
            
            $whom = "'%{\"user\":{\"id\":\"$uid\",\"seen\":%'";
            
            if($stmt = $db->prepare(" delete from register where what = 'E' and type = 'C' and who = ? and whom like $whom and link = ? and sublink = ? "))
            {
                $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                $stmt->bindValue(2, $pid, PDO::PARAM_INT);
                $stmt->bindValue(3, $id, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            } 
            $stmt->closeCursor();
            echo $index;
        }
    }
    
?>