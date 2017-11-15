<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $www = $_POST['www'];

    global $db;
    if($stmt = $db->prepare("select count(*) from users where www = ?"))
    {
        $stmt->bindValue(1, $www, PDO::PARAM_STR);
        $stmt->execute();
        $check = $stmt->fetchColumn();
        $stmt->closeCursor();
        if($check > 0) { echo "exist"; }
        else { echo "empty"; }
    }
?>