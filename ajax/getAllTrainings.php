<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    global $db;
    if($stmt = $db->prepare("select trainings.*, users.avatar, concat(users.imie,' ',users.nazwisko) as user, (users.id) as userID from trainings inner join users on trainings.who=users.id order by trainings.date desc"))
    {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        foreach ($result as $k => $v) {
            if($v['content']) {
                $result[$k]['content'] = json_decode($v['content'], true);
            }
        }
        foreach ($result as $k => $v) {
            if($v['dict']) {
                $result[$k]['dict'] = json_decode($v['dict'], true);
            }
        }
        echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>