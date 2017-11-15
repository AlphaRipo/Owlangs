<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $me = ($_POST['me']) ? $_POST['me'] : false;
    $vip = ($_POST['vip']) ? $_POST['vip'] : false;

    global $db;
    global $accessDict;
    $query = " select dict.*, users.imie, users.nazwisko, users.avatar from dict inner join users on dict.author = users.id where $accessDict order by dict.id desc ";
    
    if($stmt = $db->prepare($query))
    {
        $stmt->bindValue(1,$me,PDO::PARAM_INT);
        $stmt->bindValue(2,$me,PDO::PARAM_INT);
        $stmt->bindValue(3,$vip,PDO::PARAM_INT);
        $stmt->bindValue(4,$me,PDO::PARAM_INT);
        
        $stmt->execute();
        $dict = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach ($dict as $k1 => $v1) {
            if($v1['words']) {
                $words = json_decode($v1['words'], true);
                foreach ($words as $k2 => $v2) {

                    $author = $v2['author'];
                    if($stmt = $db->prepare(" select imie, nazwisko, avatar from users where id = ? "))
                    {
                        $stmt->bindValue(1, $author, PDO::PARAM_INT);
                        $stmt->execute();
                        $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                        $stmt->closeCursor();

                        $merged = array_merge($v2,$user);
                        $words[$k2] = $merged;
                    }
                }
                $dict[$k1]['words'] = $words;
            }
            if($stmt = $db->prepare(" select count(*) from dict_my where who = ? and what = ? "))
            {
                $stmt->bindValue(1, $me, PDO::PARAM_STR);
                $stmt->bindValue(2, $v1['id'], PDO::PARAM_STR);
                $stmt->execute();
                $exist = ["exist"=>$stmt->fetchColumn()];
                $stmt->closeCursor();
            }
            $merged = array_merge($dict[$k1],$exist);
            $dict[$k1] = $merged;
        }
        echo json_encode(array("dict"=>$dict),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }

?>