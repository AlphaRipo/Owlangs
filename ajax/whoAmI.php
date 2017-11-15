<? require_once("db.php");

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $uid = $_POST['uid'];

    global $db;
    if($stmt = $db->prepare(" select id, imie, nazwisko, lvl_ang, vip, email, avatar, back, skype, www, about from users where id = ? limit 1 "))
    {
        $stmt->bindValue(1, $uid, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $stmt->closeCursor();
        echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }

?>