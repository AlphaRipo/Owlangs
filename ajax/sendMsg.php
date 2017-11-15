<?php require_once "db.php";
    
    if(empty($_POST['me'])) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    $me = $_POST['me'];
    $who = $_POST['who'];
    $text = $_POST['text'];
    $when = date('Y-m-d H:i:s');
    $images = $_POST['images'];

    if($text or $images) {
        
        // select VIP and messages count
        
        global $db;
        if($stmt = $db->prepare(" select messages, vip from users where id = ? limit 1 ")) 
        {
            $stmt->bindValue(1, $me, PDO::PARAM_INT);
            if($stmt->execute()) {
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                if(intval($data['vip']) === 1 || intval($data['messages']) === 0) {
                    
                    // insert message
                    
                    if($stmt = $db->prepare("insert into chats set kto = ?, komu = ?, co = ?, kiedy = ?, images = ?"))
                    {
                        $stmt->bindValue(1, $me, PDO::PARAM_INT);
                        $stmt->bindValue(2, $who, PDO::PARAM_INT);
                        $stmt->bindValue(3, $text, PDO::PARAM_STR);
                        $stmt->bindValue(4, $when, PDO::PARAM_STR);
                        $stmt->bindValue(5, json_encode( $images, JSON_FORCE_OBJECT|JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                        $status = $stmt->execute();
                        
                        if($status) {
                            
                            // increase messages counter in users for user
                            
                            if($stmt = $db->prepare("update users set messages = messages + 1 where id = ?")) 
                            {
                                $stmt->bindValue(1, $me, PDO::PARAM_INT);
                                if($stmt->execute()) {
                                    echo $status;
                                }
                                $stmt->closeCursor();
                            }
                        }
                        $stmt->closeCursor();
                    }
                }
            }
            $stmt->closeCursor();
        }
    }
    
?>