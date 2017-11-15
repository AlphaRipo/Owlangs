<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $nowDT = date('Y-m-d H:i:s');
    $files = ($_POST['files']) ? $_POST['files'] : [];
    $todo = ($_POST['todo']) ? $_POST['todo'] : [];
    $content = $_POST['content'];
    $reach = $_POST['reach'];
    $id = $_POST['id'];

    if($id and $content and $nowDT)
    {
        global $db;
        if($stmt = $db->prepare(" insert into posts set kto = ?, tresc = ?, data = ?, pv = ?, gdzie = ?, reach = ?, attachments = ?, todo = ? "))
        {
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $content, PDO::PARAM_STR);
            $stmt->bindValue(3, $nowDT, PDO::PARAM_STR);
            $stmt->bindValue(4, 0, PDO::PARAM_INT);
            $stmt->bindValue(5, 0, PDO::PARAM_INT);
            $stmt->bindValue(6, $reach, PDO::PARAM_INT);
            $stmt->bindValue(7, json_encode($files,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(8, json_encode($todo,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $check = $stmt->execute();
            $stmt->closeCursor();

            $pid = $db->lastInsertId();

            if($check)
            {
                $whom = "'[{\"user\":{\"id\":\"0\",\"seen\":\"0\"}}]'";
                
                if($stmt = $db->prepare("insert into register set what = 'E', type = 'P', who = ?, whom = $whom, link = ?, added = ?"))
                {
                    $stmt->bindValue(1, $id, PDO::PARAM_INT);
                    $stmt->bindValue(2, $pid, PDO::PARAM_INT);
                    $stmt->bindValue(3, $nowDT, PDO::PARAM_STR);
                    $stmt->execute();
                }
                echo "inserted";
            }
        } 
    }
?>