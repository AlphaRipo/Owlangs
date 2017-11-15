<?php require_once "db.php";

    if(empty($_POST['mid'])) {
            $post = file_get_contents('php://input');
            $_POST = json_decode($post,true);
    }

    global $db;
    $mid = $_POST['mid'];
    $current = $_POST['current'];

    if($current) {
        $query = " select * from dict_my inner join dict on dict.id = dict_my.id_dict where dict.id > ? and dict_my.id_my = ? order by dict.id desc "; 
        if($stmt = $db->prepare($query))
        {
            $stmt->bindValue(1, $current, PDO::PARAM_INT);
            $stmt->bindValue(2, $mid, PDO::PARAM_INT);
            $stmt->execute();
            $word = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            $query = " select count(*) from dict_my inner join dict on dict.id = dict_my.id_dict where dict_my.id_my = ? "; 
            if($stmt = $db->prepare($query))
            {
                $stmt->bindValue(1, $mid, PDO::PARAM_INT);
                $stmt->execute();
                $max = $stmt->fetchColumn();
                $stmt->closeCursor();
            }

            echo json_encode(array("word"=>$word,"max"=>$max),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        }
    }
?>