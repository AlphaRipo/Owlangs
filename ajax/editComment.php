<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $id = $_POST['id'];
    $mid = $_POST['mid'];
    $content = $_POST['content'];

    global $db;
    if($stmt = $db->prepare("update comments set tresc = ?, cv = cv + 1 where id = ? and kto = ?"))
    {
        $stmt->bindValue(1, $content, PDO::PARAM_INT);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->bindValue(3, $mid, PDO::PARAM_INT);
        if($stmt->execute()) { echo "updated"; }
        $stmt->closeCursor();
    }

?>