<?php require_once "db.php";
    
    if(empty($_POST['mid'])) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    $mid = $_POST['mid'];
    $uid = $_POST['uid'];
        
    global $db;
    if($stmt = $db->prepare("select id, kto, komu, co, kiedy, images, seen from chats where (kto = ? and komu = ?) or (kto = ? and komu = ?) order by kiedy asc"))
    {
        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
        $stmt->bindValue(2,$uid,PDO::PARAM_INT);
        $stmt->bindValue(3,$uid,PDO::PARAM_INT);
        $stmt->bindValue(4,$mid,PDO::PARAM_INT);
        $stmt->execute();

        $json = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($json as $key => $value) {
            $json[$key]['images'] = json_decode($value['images'], true);
        }
        $jsonEncode = json_encode($json,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        echo $jsonEncode;
        $stmt->closeCursor();
    }
 ?>