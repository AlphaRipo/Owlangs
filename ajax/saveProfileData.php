<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $me = $_POST['me'];
    $name = $me['imie'];
    $surname = $me['nazwisko'];
    $level = $me['lvl_ang'];
    $about = $me['about'];
    $skype = $me['skype'];
    $back = $me['back'];
    $avatar = $me['avatar'];
    $pronunciation = $me['pronunciation'];
    $mid = $me['id'];

    if($me)
    {
        global $db;
        $query = " update users set imie = ?, nazwisko = ?, lvl_ang = ?, about = ?, skype = ?, back = ?, avatar = ?, pronunciation = ? where id = ? ";
        if($stmt = $db->prepare($query))
        {
            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->bindValue(2, $surname, PDO::PARAM_STR);
            $stmt->bindValue(3, $level, PDO::PARAM_STR);
            $stmt->bindValue(4, trim($about), PDO::PARAM_STR);
            $stmt->bindValue(5, $skype, PDO::PARAM_STR);
            $stmt->bindValue(6, $back, PDO::PARAM_STR);
            $stmt->bindValue(7, $avatar, PDO::PARAM_STR);
            $stmt->bindValue(8, json_encode($pronunciation,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(9, $mid, PDO::PARAM_STR);
            if($stmt->execute()) { echo "ok"; }
            $stmt->closeCursor();
        }
    }

?>