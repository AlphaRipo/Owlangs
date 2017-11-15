<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $uid = $_POST['uid'];
    $mid = $_POST['mid'];
    $id = $_POST['id'];

    if($mid and $id)
    {
        global $db;
        if($stmt = $db->prepare("insert into likes set co = ?, kto = ?"))
        {
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $mid, PDO::PARAM_INT);
            if($stmt->execute()) {
                
                $whom = "'[{\"user\":{\"id\":\"$uid\",\"seen\":\"0\"}}]'";
                
                if($stmt = $db->prepare("insert into register set what = 'E', type = 'L', who = ?, whom = $whom, link = ?, added = ?"))
                {
                    $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                    $stmt->bindValue(2, $id, PDO::PARAM_INT);
                    $stmt->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();
                } 
            }
            $stmt->closeCursor();
        }
    }
?>