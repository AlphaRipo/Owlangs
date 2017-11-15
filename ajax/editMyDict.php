<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $dict = $_POST['dict'];
    $me = $_POST['me'];
    $id = $_POST['id'];
    
    if($dict)
    {
        global $db;
        if($stmt = $db->prepare(" update dict set title = ?, description = ?, lvl = ?, author = ?, access = ?, date = ?, version = version + 1 where id = ? "))
        {
            $stmt->bindValue(1, $dict['title'], PDO::PARAM_STR);
            $stmt->bindValue(2, $dict['description'], PDO::PARAM_STR);
            $stmt->bindValue(3, $dict['lvl'], PDO::PARAM_STR);
            $stmt->bindValue(4, $dict['author'], PDO::PARAM_INT);
            $stmt->bindValue(5, $dict['access'], PDO::PARAM_INT);
            $stmt->bindValue(6, date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(7, $dict['id'], PDO::PARAM_INT);
            if($stmt->execute()) { echo "updated"; }
            $stmt->closeCursor();
        }
    }

?>