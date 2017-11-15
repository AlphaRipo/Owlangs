<?php require_once "db.php";

    $nr = $_POST['nr'];
    $mid = $_POST['mid'];

    global $db;
    if($stmt = $db->prepare("select count(*) from trainings where id = ? and who = ?"))
    {
        $stmt->bindValue(1, $nr, PDO::PARAM_INT);
        $stmt->bindValue(2, $mid, PDO::PARAM_INT);
        $stmt->execute();
        $check = $stmt->fetchColumn();
        if($check > 0)
        {
            $stmt->closeCursor();
            if($stmt = $db->prepare("delete from trainings where id = ? and who = ?"))
            {
                $stmt->bindValue(1, $nr, PDO::PARAM_INT);
                $stmt->bindValue(2, $mid, PDO::PARAM_INT);
                if($stmt->execute())
                {
                    $whom = "'%{\"user\":{\"id\":\"0\",\"seen\":%'";
                    
                    $stmt->closeCursor();
                    if($stmt = $db->prepare("select sublink from register where what = 'E' and type = 'T' and who = ? and whom like $whom and link = ? limit 1"))
                    {
                        $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                        $stmt->bindValue(2, $nr, PDO::PARAM_INT);
                        if($stmt->execute())
                        {
                            $res = $stmt->fetchColumn();

                            $stmt->closeCursor();
                            if($stmt = $db->prepare(" delete from register where what = 'E' and type = 'T' and who = ? and whom like $whom and link = ? "))
                            {
                                $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                                $stmt->bindValue(2, $nr, PDO::PARAM_INT);
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
                }
                $stmt->closeCursor();
                echo "ok";
            }
        }
    }

?>