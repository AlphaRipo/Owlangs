<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $id = $_POST['post']['id'];
    $kto = $_POST['post']['kto'];
    $mid = $_POST['mid'];
    $o = $_POST['post'];

    if($kto === $mid)
    {
        global $db;
        if($stmt = $db->prepare("update posts set tresc = ?, reach = ?, pv = pv + 1 where id = ?")) 
        {
            $stmt->bindValue(1, $o['tresc'], PDO::PARAM_STR);
            $stmt->bindValue(2, $o['reach'], PDO::PARAM_INT);
            // $stmt->bindValue(3, $post['todo'], PDO::PARAM_INT);
            // $stmt->bindValue(4, $post['attachments'], PDO::PARAM_INT);
            $stmt->bindValue(3, $id, PDO::PARAM_INT);
            if($stmt->execute()) { echo "ok"; }
            $stmt->closeCursor();
        }
    }

?>