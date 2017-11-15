<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $obj = $_POST['event'];
    $title = $obj['title'];
    $desc = $obj['desc'];
    $people = $obj['people'];
    $start = $obj['start'];
    $end = $obj['end'];
    $who = $obj['who'];
    $id = $obj['id'];
    
    if($people)
    {
        global $db;
        if($stmt = $db->prepare(" update events set title=?, description=?, people=?, start=?, end=?, who=? where id=? "))
        {
            $stmt->bindValue(1, $title, PDO::PARAM_STR);
            $stmt->bindValue(2, $desc, PDO::PARAM_STR);
            $stmt->bindValue(3, json_encode($people,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(4, $start, PDO::PARAM_STR);
            $stmt->bindValue(5, $end, PDO::PARAM_STR);
            $stmt->bindValue(6, $who, PDO::PARAM_INT);
            $stmt->bindValue(7, $id, PDO::PARAM_INT);
            if($stmt->execute()) { echo "updated"; }
            $stmt->closeCursor();
        }
    }

?>