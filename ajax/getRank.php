<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $me = $_POST['me'];

    global $db;
    $query = " SELECT id, ((scTranslate/7) + (scTrain/4) + (scHelp/10)) AS score, 
        FIND_IN_SET( ((scTranslate/7) + (scTrain/4) + (scHelp/10)), (    
        SELECT GROUP_CONCAT( ((scTranslate/7) + (scTrain/4) + (scHelp/10))
        ORDER BY ((scTranslate/7) + (scTrain/4) + (scHelp/10)) DESC ) 
        FROM users )) AS rank FROM users WHERE id =  ? limit 1 "; // nic nie kumam ale działa! :)

    if($stmt = $db->prepare($query))
    {
        $stmt->bindValue(1, $me, PDO::PARAM_INT);
        $stmt->execute();
        $your_rank = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $stmt->closeCursor();
        echo json_encode($your_rank,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>