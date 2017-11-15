<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $dict = $_POST['dict'];
    if($dict)
    {
        global $db;
        if($stmt = $db->prepare("select author from dict where id = ?"))
        {
            $stmt->bindValue(1, $dict['id'], PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            if($result == $dict['author'])
            {
                $stmt->closeCursor();
                if($stmt = $db->prepare("delete from dict where id = ?"))
                {
                    $stmt->bindValue(1, $dict['id'], PDO::PARAM_INT);
                    if($stmt->execute()){ 
                        
                        $whom = "'%{\"user\":{\"id\":\"0\",\"seen\":%'";
                        
                        $stmt->closeCursor();
                        if($stmt = $db->prepare("select sublink from register where what = 'E' and type = 'W' and who = ? and whom like $whom and link = ? limit 1"))
                        {
                            $stmt->bindValue(1, $dict['author'], PDO::PARAM_INT);
                            $stmt->bindValue(2, $dict['id'], PDO::PARAM_INT);
                            if($stmt->execute())
                            {
                                $res = $stmt->fetchColumn();
                                
                                $stmt->closeCursor();
                                if($stmt = $db->prepare(" delete from register where what = 'E' and type = 'W' and who = ? and whom like $whom and link = ? "))
                                {
                                    $stmt->bindValue(1, $dict['author'], PDO::PARAM_INT);
                                    $stmt->bindValue(2, $dict['id'], PDO::PARAM_INT);
                                    $stmt->execute();
                                }
                                
                                $stmt->closeCursor();
                                if($stmt = $db->prepare(" delete from posts where id = ? "))
                                {
                                    $stmt->bindValue(1, $res, PDO::PARAM_INT);
                                    $stmt->execute();
                                }
                            } 
                        }
                        echo " deteleted dict ";
                    }
                    
                    $stmt->closeCursor();
                    if($stmt = $db->prepare("delete from dict_my where what = ?"))
                    {
                        $stmt->bindValue(1, $dict['id'], PDO::PARAM_INT);
                        if($stmt->execute()){ echo " deteleted dict_my "; }
                        $stmt->closeCursor();
                    }
                }
            }
        }
    }
?>