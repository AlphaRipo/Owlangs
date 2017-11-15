<?php require_once "db.php";
    
    if(empty($_POST['me'])) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    $me = $_POST['me'];
    $id = $_POST['id'];

    if($me and $id) {
        
        global $db;
        if($stmt = $db->prepare(" update chats set seen = 1 where id = ? and komu = ? "))
        {
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $me, PDO::PARAM_INT);
            $status = $stmt->execute();
            $stmt->closeCursor();
            echo $status;
        }
    }
    
    
 ?>