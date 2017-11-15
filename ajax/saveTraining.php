<?php require_once "db.php";
    
    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $data = $_POST['training'];
    
    if($data['who'] and $data['name']) { echo ' if1 ';
        
        global $db;
        if($stmt = $db->prepare(" insert into trainings set date = ?, name = ?, ask = ?, who = ?, type = ?, content = ?, dict = ?, groups = ?, lvl = ? ")) {
            
            $stmt->bindValue(1, date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(2, $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(3, ($data['ask']) ? $data['ask'] : '', PDO::PARAM_STR);
            $stmt->bindValue(4, $data['who'], PDO::PARAM_INT);
            $stmt->bindValue(5, $data['type'], PDO::PARAM_INT);
            $stmt->bindValue(6, json_encode( $data['content'], JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(7, json_encode( $data['dict'], JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(8, $data['groups'], PDO::PARAM_INT);
            $stmt->bindValue(9, $data['lvl'], PDO::PARAM_STR);
            $check1 = $stmt->execute();
            $stmt->closeCursor();
            $tid = $db->lastInsertId();
                
            if($check1 and $data['groups'] < 3) { echo 'if2 ';
                
                if($stmt = $db->prepare(" insert into posts set kto = ?, tresc = ?, data = ?, pv = ?, gdzie = ?, reach = ?, attachments = ?, todo = ? ")) {
                    
                    $stmt->bindValue(1, $data['who'], PDO::PARAM_INT);
                    $stmt->bindValue(2, "Check out my new exercise!", PDO::PARAM_STR);
                    $stmt->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $stmt->bindValue(4, 0, PDO::PARAM_INT);
                    $stmt->bindValue(5, 0, PDO::PARAM_INT);
                    $stmt->bindValue(6, $data['groups'], PDO::PARAM_INT);
                    $stmt->bindValue(7, json_encode([],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                    $stmt->bindValue(8, json_encode(['tname'=>$data['name'],'tid'=>$tid],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                    $check2 = $stmt->execute();
                    $stmt->closeCursor();
                    $pid = $db->lastInsertId();
                }
                
                if($check2) { echo ' if3 ';
                    
                    $whom = "'[{\"user\":{\"id\":\"0\",\"seen\":\"0\"}}]'";
                
                    if($stmt = $db->prepare(" insert into register set what = 'E', type = 'T', who = ?, whom = $whom, seen = 0, link = ?, sublink = ?, added = ? ")) {
                        
                        $stmt->bindValue(1, $data['who'], PDO::PARAM_INT);
                        $stmt->bindValue(2, $tid, PDO::PARAM_INT);
                        $stmt->bindValue(3, $pid, PDO::PARAM_INT);
                        $stmt->bindValue(4, date('Y-m-d H:i:s'), PDO::PARAM_STR);
                        if($stmt->execute()) { echo ' if4 '; }
                    }
                }
            }
        }
    }
?>