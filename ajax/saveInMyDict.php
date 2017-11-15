<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $what = $_POST['id'];
    $who = $_POST['me'];
    
    global $db;
    
    if($stmt = $db->prepare("select count(*) from dict_my where who = ? and what = ?"))
    {
        $stmt->bindValue(1, $who, PDO::PARAM_INT);
        $stmt->bindValue(2, $what, PDO::PARAM_INT);
        if($stmt->execute()) { echo "selected"; }
        $res = $stmt->fetchColumn();
        $stmt->closeCursor();
        
        if($res == 0) {
            
            if($stmt = $db->prepare("insert into dict_my set who = ?, what = ?"))
            {
                $stmt->bindValue(1, $who, PDO::PARAM_INT);
                $stmt->bindValue(2, $what, PDO::PARAM_INT);
                if($stmt->execute()) { echo "inserted"; }
                $stmt->closeCursor();
            }
        }
    }

?>