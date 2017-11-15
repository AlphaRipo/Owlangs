<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $nr = $_POST['nr'];
    $mid = $_POST['mid'];

    global $db;
    if($stmt = $db->prepare("select count(*) from trainings_my where mid = ? and tid = ?"))
    {
        $stmt->bindValue(1, $mid, PDO::PARAM_INT);
        $stmt->bindValue(2, $nr, PDO::PARAM_INT);
        $stmt->execute();
        $check = $stmt->fetchColumn();
        $stmt->closeCursor();
        echo ($check > 0) ? true : false;
    }
?>
