<?php require_once "db.php";

    if(empty($_POST['mid'])) {
            $post = file_get_contents('php://input');
            $_POST = json_decode($post,true);
    }

    $mid = $_POST['mid'];
    $dict = $_POST['dict'];

    if($dict)
    {
        global $db;
        foreach ($dict as $key => $value)
        {
            $audio = '';
            $image = '';

            if(isset($value['img'])) $image = $value['img'];
            if(isset($value['audio'])) $audio = $value['audio'];
            if($stmt = $db->prepare(" insert into dict set pl = ?, en = ?, audio = ?, img = ?, who = ? "))
            {
                $stmt->bindValue(1, cnWordWrap($value['pl']), PDO::PARAM_STR);
                $stmt->bindValue(2, cnWordWrap($value['en']), PDO::PARAM_STR);
                $stmt->bindValue(3, $audio, PDO::PARAM_STR);
                $stmt->bindValue(4, $image, PDO::PARAM_STR);
                $stmt->bindValue(5, $mid, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
            $last = $db->lastInsertId();
            $dict[$key] = array_merge($dict[$key], array("id" => $last));

            if($stmt = $db->prepare(" insert into dict_my set id_my = ?, id_dict = ? "))
            {
                $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                $stmt->bindValue(2, $last, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
        }
    }
        
?>