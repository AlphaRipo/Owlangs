<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $www = $_POST['www'];
    $me = $_POST['me'];

    if($www and $me)
    {
        global $db;
        if($stmt = $db->prepare("select count(*) from users where www = ?"))
        {
            $stmt->bindValue(1, $www, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            $stmt->closeCursor();

            if($result == 0)
            {
                if($stmt = $db->prepare("update users set www = ? where id = ?"))
                {
                    $stmt->bindValue(1, $www, PDO::PARAM_STR);
                    $stmt->bindValue(2, $me, PDO::PARAM_STR);
                    if($stmt->execute()) { echo "updated"; }
                    $stmt->closeCursor();
                }
            }
            else { echo "found"; }
        }
    }
?>