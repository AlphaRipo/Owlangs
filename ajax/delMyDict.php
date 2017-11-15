<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $what = $_POST['id'];
    $who = $_POST['me'];
    
    global $db;

    if($stmt = $db->prepare("delete from dict_my where who = ? and what = ?"))
    {
        $stmt->bindValue(1, $who, PDO::PARAM_INT);
        $stmt->bindValue(2, $what, PDO::PARAM_INT);
        if($stmt->execute()) { echo "deteleted"; }
        $stmt->closeCursor();
    }
?>