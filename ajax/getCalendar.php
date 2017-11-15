<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $me = $_POST['me'];
    
    if($me)
    {
        global $db;
        if($stmt = $db->prepare(" select * from events where who = ? or people like ? "))
        {
            $stmt->bindValue(1, $me, PDO::PARAM_STR);
            $stmt->bindValue(2, '%"id":'.$me.',%', PDO::PARAM_STR);
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