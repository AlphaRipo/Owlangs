<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $registerItems = $_POST['items'];
    $me = $_POST['me'];

    global $db;

    foreach ($registerItems as $registerItem) {
        
        foreach ($registerItem['whom'] as $j => $user) {
            
            if($me == $registerItem['whom'][$j]['user']['id']) {
                $registerItem['whom'][$j]['user']['seen'] = 1;
                var_dump($registerItem);
                break;
            }
        }
        
//        if($stmt = $db->prepare("update register set whom = ? where id = ? and who = ? and link = ?"))
//        {
//            $stmt->bindValue(1, json_encode($registerItem['whom'], JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
//            $stmt->bindValue(2, $registerItem['id'], PDO::PARAM_INT);
//            $stmt->bindValue(3, $registerItem['who'], PDO::PARAM_INT);
//            $stmt->bindValue(4, $registerItem['link'], PDO::PARAM_INT);
//            if($stmt->execute()) { echo " updated id: ".$registerItem['id']; }
//            $stmt->closeCursor();
//        }
    }

?>