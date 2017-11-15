<?php require_once "db.php";
    
    global $db;
    $query = " select imie, nazwisko, avatar, vip, id, ((scTranslate/7) + (scTrain/4) + (scHelp/10)) as rank from users order by rank desc, id asc limit 1 ";
    if($stmt = $db->prepare($query))
    {
        $stmt->execute();
        $the_best = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }

    $query = " select imie, nazwisko, avatar, vip, id, (scTranslate/7) as rank from users order by rank desc, id asc limit 6 ";
    if($stmt = $db->prepare($query))
    {
        $stmt->execute();
        $the_best_r1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }

    $query = " select imie, nazwisko, avatar, vip, id, (scTrain/4) as rank from users order by rank desc, id asc limit 6 ";
    if($stmt = $db->prepare($query))
    {
        $stmt->execute();
        $the_best_r2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }

    $query = " select imie, nazwisko, avatar, vip, id, (scHelp/10) as rank from users order by rank desc, id asc limit 6 ";
    if($stmt = $db->prepare($query))
    {
        $stmt->execute();
        $the_best_r3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }
    echo json_encode(['winner'=>$the_best,'creative'=>$the_best_r1,'helpful'=>$the_best_r2,'translator'=>$the_best_r3],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
?>