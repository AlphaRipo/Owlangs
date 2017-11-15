<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);

    $obj = $_POST['obj'];
    $title = $obj['title'];
    $desc = $obj['desc'];
    $start = $obj['start'];
    $end = $obj['end'];
    $people = $obj['people'];
    $me = $_POST['me'];
    
    $todo = [
        "did"=>$obj['dict']['id'],
        "dname"=>$obj['dict']['name'],
        "tid"=>$obj['training']['id'],
        "tname"=>$obj['training']['name']
    ];
    
    if($people)
    {
        global $db;
        if($stmt = $db->prepare(" insert into events set title=?, description=?, who=?, start=?, end=?, saved=?, people=?, todo=? "))
        {
            $stmt->bindValue(1, $title, PDO::PARAM_STR);
            $stmt->bindValue(2, $desc, PDO::PARAM_STR);
            $stmt->bindValue(3, $me, PDO::PARAM_INT);
            $stmt->bindValue(4, $start, PDO::PARAM_STR);
            $stmt->bindValue(5, $end, PDO::PARAM_STR);
            $stmt->bindValue(6, date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(7, json_encode($people,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->bindValue(8, json_encode($todo,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);

            if($stmt->execute()) {
                
                $eid = $db->lastInsertId();
                
                if($stmt = $db->prepare("insert into register set what = 'E', type = 'D', who = ?, whom = ?, link = ?, added = ?"))
                {
                    $tab = [];
                    foreach ($people as $person) {
                        $user = $person['id'];
                        $tab[] = [
                            "user" => [
                                "id" => $user,
                                "seen" => 0
                            ]
                        ];
                    }
                    $stmt->bindValue(1, $me, PDO::PARAM_INT);
                    $stmt->bindValue(2, json_encode($tab,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_INT);
                    $stmt->bindValue(3, $eid, PDO::PARAM_INT);
                    $stmt->bindValue(4, date('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();
                }
            }
            $stmt->closeCursor();
        }
        if($stmt = $db->prepare(" select * from events where who = ? "))
        {
            $stmt->bindValue(1, $me, PDO::PARAM_STR);
            $stmt->execute();
            $myEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            foreach ($myEvents as $k => $myEvent) {
                if($myEvent['people']) {
                    $myEvents[$k]['people'] = json_decode($myEvent['people'], true);
                }
                if($myEvent['todo']) {
                    $myEvents[$k]['todo'] = json_decode($myEvent['todo'], true);
                }
                if($myEvent['who'] == $me && amIInPeople($myEvent['people'],$me)) {
                    $myEvents[$k]['className'] = "me";
                }
                else { $myEvents[$k]['className'] = "notme"; }
            }
            echo json_encode($myEvents,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        }
    }
    
    function amIInPeople($people,$me) {
        if (strpos($people,'"id":'.$me.',') !== false) {
            return true;
        } else { return false; }
    }

?>