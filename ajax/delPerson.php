<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $people = $_POST['people'];
    $id = $_POST['id'];
    
    if($id)
    {
        global $db;
        if($stmt = $db->prepare(" update events set people=? where id=? "))
        {
            $stmt->bindValue(1, json_encode($people,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(2, $id, PDO::PARAM_INT);
            
            if($stmt->execute()) { 
                
                $tab = [];
                foreach ($people as $person) { 
                    if($id != $person['id']) { 
                        $user = $person['id'];
                        $tab[] = [
                            "user" => [
                                "id" => $user,
                                "seen" => 0
                            ]
                        ];
                    }
                }
                if($stmt = $db->prepare(" update register set whom = ? where what = 'E' and type = 'D' and link = ? "))
                {
                    $stmt->bindValue(1, json_encode($tab,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                    $stmt->bindValue(2, $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->closeCursor();
                }
                echo " updated ";              
            }
            
            $stmt->closeCursor();
        }
    }

?>