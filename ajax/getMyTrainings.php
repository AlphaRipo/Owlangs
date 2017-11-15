<?php require_once "db.php";

    $nr = null;
    $midQuery = null;
    $midInteger = null;
    $and = null;
    $mode = null;

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
        
    if(isset($_POST['mid'])) {
        $midQuery = " trainings.who = ".$_POST['mid'];
        $midInteger = $_POST['mid'];
    }
    if(isset($_POST['mode'])) { $mode = $_POST['mode']; }
    if(isset($_POST['nr'])) { $nr = " trainings.id = ". $_POST['nr'] ." "; }
    if($midQuery and $nr) { $and = " and "; }

    global $db;
    
    if($mode == "teach") {

        if($stmt = $db->prepare(" select exercises, vip from users where id = ? limit 1 ")) {
            
            $stmt->bindValue(1, $_POST['me'], PDO::PARAM_INT);
            if($stmt->execute()) {

                $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                if(intval($data['vip']) === 1 || intval($data['exercises']) <= 5) { // vip or less than 5 daily

                    // get single training
                    $cannot = 0;

                    if($stmt = $db->prepare("select trainings.*, users.avatar, concat(users.imie,' ',users.nazwisko) as user, (users.id) as userID from trainings inner join users on trainings.who = users.id where $midQuery $and $nr order by trainings.date desc"))
                    {
                        if($midQuery) { $stmt->bindValue(1,$midQuery,PDO::PARAM_INT); }
                        if($stmt->execute()) {

                            if($nr) { // insert exercises

                                if($substmt = $db->prepare("update users set exercises = exercises + 1 where id = ?")) {
                                    $substmt->bindValue(1, $_POST['me'], PDO::PARAM_INT);
                                    $substmt->execute();
                                    $substmt->closeCursor();
                                }
                            }
                        }
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
                    }
                } else { 
                    $cannot = 1;
                }
                echo json_encode(['results'=>$result,'cannot'=>$cannot],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
                $stmt->closeCursor();
            }
            $stmt->closeCursor();
        }
    }
    elseif($mode == "learn") {
        if($stmt = $db->prepare("select trainings_my.*, trainings.*, users.avatar, concat(users.imie,' ',users.nazwisko) as user, (users.id) as userID from trainings_my inner join trainings on trainings_my.tid = trainings.id inner join users on trainings.who = users.id where trainings_my.mid = ? order by trainings.date desc"))
        {
            $stmt->bindValue(1,$midInteger,PDO::PARAM_INT);
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
    }

?>