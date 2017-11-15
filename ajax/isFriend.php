<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $mid = $_POST['mid'];
    $uid = $_POST['uid'];

    global $db;
    $query = " select count(*) from friends where friends.id_0 = ? and friends.id_1 = ? ";

    if($stmt = $db->prepare($query))
    {
        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
        $stmt->bindValue(2,$uid,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        $stmt->closeCursor();
        echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>