<?php require_once "db.php";
    
    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $mid = $_POST['mid'];
        
    global $db;
    if($stmt = $db->prepare(" select friends.*, users.vip, users.avatar, users.imie, users.nazwisko, users.lvl_ang from friends inner join users on friends.id_1 = users.id where id_0 = ? order by friends.id desc "))
    {
        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
        $stmt->execute();
        $following = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }
    if($stmt = $db->prepare(" select friends.*, users.vip, users.avatar, users.imie, users.nazwisko, users.lvl_ang from friends inner join users on friends.id_0 = users.id where id_1 = ? order by friends.id desc "))
    {
        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
        $stmt->execute();
        $followers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }
    echo json_encode(["following"=>$following,"followers"=>$followers],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
 ?>