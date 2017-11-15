<?php require_once "db.php";

    if(empty($_POST['mid'])) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    $mid = $_POST['mid'];
    $id = $_POST['id'];

    if($mid and $id)
    {
        global $db;
        if($stmt = $db->prepare("insert into friends set id_0 = ?, id_1 = ?, since = ?"))
        {
            $stmt->bindValue(1, $mid, PDO::PARAM_INT);
            $stmt->bindValue(2, $id, PDO::PARAM_INT);
            $stmt->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);

            if($stmt->execute()) {
                
                $whom = "'[{\"user\":{\"id\":\"$id\",\"seen\":\"0\"}}]'";
                
                if($stmt = $db->prepare("insert into register set what = 'F', type = 'F', who = ?, whom = $whom, seen = 0, link = ?, added = ?"))
                {
                    $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                    $stmt->bindValue(2, $mid, PDO::PARAM_INT);
                    $stmt->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $stmt->execute();
                }
            }
            
            $stmt->closeCursor();
        }
    }
?>