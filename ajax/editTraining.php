<?php require_once "db.php";
    
    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $data = $_POST['training'];
    
    if($data['who'] and $data['name']) { 
        
        global $db;
        if($stmt = $db->prepare(" update trainings set date = ?, name = ?, ask = ?, who = ?, type = ?, content = ?, dict = ?, groups = ?, lvl = ? where id = ? ")) {

            $stmt->bindValue(1, date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(2, $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(3, $data['ask'], PDO::PARAM_STR);
            $stmt->bindValue(4, $data['who'], PDO::PARAM_INT);
            $stmt->bindValue(5, $data['type'], PDO::PARAM_INT);
            $stmt->bindValue(6, json_encode( $data['content'], JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(7, json_encode( $data['dict'], JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(8, $data['groups'], PDO::PARAM_INT);
            $stmt->bindValue(9, $data['lvl'], PDO::PARAM_STR);
            $stmt->bindValue(10, $data['id'], PDO::PARAM_INT);
            if($stmt->execute()) {
                
                $tid = $data['id'];
                echo ' updated training no. '.$tid;
                
                if($stmt = $db->prepare(" select sublink from register where link = ? limit 1 ")) { 

                    $stmt->bindValue(1, $tid, PDO::PARAM_INT);
                    $stmt->execute();
                    $sublink = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['sublink'];
                    
                    if($stmt = $db->prepare(" update posts set reach = ?, pv = pv + 1 where id = ? ")) { 

                        $stmt->bindValue(1, $data['groups'], PDO::PARAM_INT);
                        $stmt->bindValue(2, $sublink, PDO::PARAM_INT);
                        if($stmt->execute()) { echo ' updated post no. '.$sublink; }
                    }
                }
            }
            $stmt->closeCursor();
        }
    }
?>
