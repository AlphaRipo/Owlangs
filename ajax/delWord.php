<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $index = $_POST['index'];
    $word = $_POST['word'];
    $id = $_POST['id'];

    global $db;

    if($stmt = $db->prepare(" select words from dict where id = ? "))
    {
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = json_decode($stmt->fetchColumn(), true);
        $stmt->closeCursor();
        
        if($data) {
            foreach ($data as $key => $value) {
                if($key === $index and $value['en'] === $word['en']) {
                    unset($data[$key]);
                }
            }
            if($stmt = $db->prepare(" update dict set words = ? where id = ? "))
            {
                $stmt->bindValue(1, json_encode(array_values($data),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                $stmt->bindValue(2, $id, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
            echo json_encode(array("can"=>array_values($data)),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        }
    }
    
?>