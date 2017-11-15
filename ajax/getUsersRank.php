<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $mid = $_POST['mid'];

    global $db;
    $query = " select users.avatar, users.imie, users.nazwisko, users.vip, users.id, users.lvl_ang, users.scHelp, users.scTrain, users.scTranslate, 
        (select count(*) from friends where (friends.id_0 = ? and friends.id_1 = users.id)) as friends, 
        ((scTranslate/7) + (scTrain/4) + (scHelp/10)) as rank from users order by vip desc, rank desc, id asc ";

    if($stmt = $db->prepare($query))
    {
        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>