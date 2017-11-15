<?php require_once "db.php";

    if(!$_POST['id']) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    
    global $db;
    if($stmt = $db->prepare(" update articles set html = ? where id = ? "))
    {
        $stmt->bindValue(1, $_POST['html'], PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['id'], PDO::PARAM_INT);
        $mode = $stmt->execute();
        $stmt->closeCursor();
        echo $mode;
    }

?>