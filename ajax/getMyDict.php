<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
                
    $me = ($_POST['me']) ? $_POST['me'] : false;
    $vip = ($_POST['vip']) ? $_POST['vip'] : false;
    
    global $db;
    global $accessDict;
    $query = " select dict.*, users.imie, users.nazwisko, users.avatar from dict inner join users on dict.author = users.id inner join dict_my on dict_my.what = dict.id where ( $accessDict ) and dict_my.who = ? order by dict_my.id desc ";
    
    if($stmt = $db->prepare($query))
    {
        $stmt->bindValue(1,$me,PDO::PARAM_INT);
        $stmt->bindValue(2,$me,PDO::PARAM_INT);
        $stmt->bindValue(3,$vip,PDO::PARAM_INT);
        $stmt->bindValue(4,$me,PDO::PARAM_INT);
        $stmt->bindValue(5,$me,PDO::PARAM_INT);
        
        $stmt->execute();
        $dict = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach ($dict as $k => $v) {
            if($v['words']) {
                $dict[$k]['words'] = json_decode($v['words'], true);
            }
        }
        echo json_encode(array("dict"=>$dict),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>