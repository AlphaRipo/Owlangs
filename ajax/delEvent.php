<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $who = $_POST['who'];
    $id = $_POST['id'];
    
    if($id and $who)
    {
        global $db;
        if($stmt = $db->prepare(" delete from events where id=? and who=? "))
        {
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $who, PDO::PARAM_INT);
            
            if($stmt->execute()){ 
                
                if($stmt = $db->prepare(" delete from register where what = 'E' and type = 'D' and who = ? and link = ? "))
                {
                    $stmt->bindValue(1, $who, PDO::PARAM_INT);
                    $stmt->bindValue(2, $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->closeCursor();
                }
                echo " deteleted ";              
            }
            
            $stmt->closeCursor();
        }
    }

?>