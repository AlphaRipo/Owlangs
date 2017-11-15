<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $words = $_POST['words'];
    $sd = $_POST['sd'];
    $id = $sd['id'];

    global $db;
    foreach ($words as $key => $value) {
        if($value['en'] === "" ) { unset($words[$key]); }
        else { $words[$key] = array_merge($value,array( "imie" => $sd['imie'], "nazwisko" => $sd['nazwisko'], "avatar" => $sd['avatar'] )); }
    }

    if($stmt = $db->prepare(" select words from dict where id = ? "))
    {
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $old = json_decode($stmt->fetchColumn(), true);
        $stmt->closeCursor();

        if($old) { $new = array_merge($old,$words); }
        else { $new = $words; }

        if($stmt = $db->prepare(" update dict set words = ? where id = ? "))
        {
            $stmt->bindValue(1, json_encode( $new, JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE ), PDO::PARAM_STR);
            $stmt->bindValue(2, $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            echo json_encode(array("can"=>$new),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        }
    }
?>