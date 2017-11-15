<?php require_once "db.php";

    if(!$_POST['id']) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    $id = $_POST['id'];
    
    global $db;
    if($stmt = $db->prepare(" select html from articles where id = ? "))
    {
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $mode = $stmt->execute();
        $article = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['html'];
        $stmt->closeCursor();

        if($mode) { echo $article; }
    }

?>