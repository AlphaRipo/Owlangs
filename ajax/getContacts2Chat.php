<?php require_once "db.php";
    
    if(empty($_POST['mid'])) {
        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);
    }

    $mid = $_POST['mid'];

    global $db;
    if($stmt = $db->prepare("select * from friends inner join users on users.id = friends.id_1 where friends.id_0 = ? order by users.available desc"))
    {
        $stmt->bindValue(1,$mid,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $arrays = null;

        foreach ($result as $i => $v)
        {
                $arrays[$i] = array('id'=>$v['id'],'skype'=>$v['skype'],'lvl_ang'=>$v['lvl_ang'],'avatar'=>$v['avatar'],'nazwisko'=>$v['nazwisko'],'imie'=>$v['imie'],'available'=>$v['available']);
        }
        echo json_encode($arrays,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>