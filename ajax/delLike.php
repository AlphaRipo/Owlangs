<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $uid = $_POST['uid'];
    $mid = $_POST['mid'];
    $id = $_POST['id'];

    if($mid and $id)
    {
        global $db;
        if($stmt = $db->prepare(" delete from likes where co = ? and kto = ? "))
        {
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $mid, PDO::PARAM_INT);
            if($stmt->execute()) {
                
                $whom = "'%{\"user\":{\"id\":\"$uid\",\"seen\":%'";
                
                if($stmt = $db->prepare(" delete from register where what = 'E' and type = 'L' and who = ? and whom like $whom and link = ? "))
                {
                    $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                    $stmt->bindValue(2, $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->closeCursor();
                } 
            }
            $stmt->closeCursor();
        } 
    }
?>