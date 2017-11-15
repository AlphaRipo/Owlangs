<?php require_once "db.php";

    $query = " select dict2.pl, dict2.en, dict2.author, dict2.image, dict2.audio, dict2.example, users.imie, users.nazwisko, users.avatar from dict2 inner join users on dict2.author = users.id order by dict2.author asc, dict2.id asc ";
    if($stmt = $db->prepare($query))
    {
        $stmt->execute();
        $dict2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }
    
    $dicts = [];
    $words = [];
    
    foreach ($dict2 as $i => $v) {
        
        $current = $v['author'];
        $next = ($dict2[$i+1]['author']) ? $dict2[$i+1]['author'] : -1;

        array_push($words,$v);
        
        if($current != $next) {
            
            $dict = [
                "words"=>$words,
                "title"=>"Old Words",
                "description"=>"Click on edit button and change title, desc, etc.",
                "lvl"=>"A1",
                "author"=>$current,
                "access"=>"0",
                "date"=>date('Y-m-d H:i:s'),
                "version"=>"0"
            ];
            
            array_push($dicts,$dict);
            $words = [];
        }
    }
    print_r($dicts);
    
    foreach ($dicts as $i => $v) {
        
        $query = " insert into dict set words = ?, title = ?, description = ?, lvl = ?, author = ?, access = ?, date = ?, version = ? ";
        if($stmt = $db->prepare($query))
        {
            $stmt->bindValue(1,json_encode(array_values($v['words']),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE),PDO::PARAM_STR);
            $stmt->bindValue(2,$v['title'],PDO::PARAM_STR);
            $stmt->bindValue(3,$v['description'],PDO::PARAM_STR);
            $stmt->bindValue(4,$v['lvl'],PDO::PARAM_INT);
            $stmt->bindValue(5,$v['author'],PDO::PARAM_INT);
            $stmt->bindValue(6,$v['access'],PDO::PARAM_INT);
            $stmt->bindValue(7,$v['date'],PDO::PARAM_STR);
            $stmt->bindValue(8,$v['version'],PDO::PARAM_INT);
            
            $stmt->execute();
            $stmt->closeCursor();
        }
    }

?>