<? require_once 'db.php';

    if(empty($_POST['me'])) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }
    $lastest = $_POST['lastest'];
    $who = $_POST['who'];
    $me = $_POST['me'];
    
    global $db;
    if($stmt = $db->prepare(" select * from chats where id > $lastest and ((kto = $me and komu = $who) or (kto = $who and komu = $me)) order by kiedy asc "))
    {
        $stmt->bindValue(1,$lastest,PDO::PARAM_INT);
        $stmt->bindValue(2,$me,PDO::PARAM_INT);
        $stmt->bindValue(3,$who,PDO::PARAM_INT);
        $stmt->bindValue(4,$who,PDO::PARAM_INT);
        $stmt->bindValue(5,$me,PDO::PARAM_INT);
        $stmt->execute();
        
        $json = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($json as $key => $value) {
            $json[$key]['images'] = json_decode($value['images'], true);
        }
        $stmt->closeCursor();
        echo json_encode($json,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        
    }
    
?>