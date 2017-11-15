<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $mid = $_POST['mid'];
    $mode = ($_POST['mode']) ? $_POST['mode'] : 0;

    if($mid) {
        
        global $db;
        if($stmt = $db->prepare("select count(*) from users where id = ? and available = ?")) { 
            
            $stmt->bindValue(1, $mid, PDO::PARAM_INT);
            $stmt->bindValue(2, $mode, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            $stmt->closeCursor();

            if($result == 0) {
                
                if($stmt = $db->prepare("update users set available = ? where id = ?")) {
                    
                    $stmt->bindValue(1, $mode, PDO::PARAM_INT);
                    $stmt->bindValue(2, $mid, PDO::PARAM_INT);
                    if($stmt->execute()) { echo "updated"; }
                    $stmt->closeCursor();
                }
            }
            else { echo "count"; }
        }
    }

?>