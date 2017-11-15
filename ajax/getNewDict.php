<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    
    $me = ($_POST['me']) ? $_POST['me'] : false;
    $vip = ($_POST['vip']) ? $_POST['vip'] : false;
    $tab = $_POST['tab'];
    
    $newDicts = [];
    $updatedDicts = [];
    $deletedDicts = [];
    
    function compare2EditInDB ($id,$version) {
        global $db;
        if($stmt = $db->prepare(" select count(id) from dict where id = ? and version > ? "))
        {
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $version, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if($count > 0) {
                $temp = getDict($id);
            }
            $stmt->closeCursor();
        }
        return $temp;
    }
    
    function compare2DeteleInDB ($id) {
        global $db;
        if($stmt = $db->prepare(" select count(id) from dict where id = ? "))
        {
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if($count > 0) {
                return true;
            }
            else { return false; }
            $stmt->closeCursor();
        }
    }
    
    function getDict($frontId) {

        global $db;
        $query = " select dict.*, users.imie, users.nazwisko, users.avatar from dict inner join users on dict.author = users.id where dict.id = ? ";
        
        if($stmt = $db->prepare($query))
        {
            $stmt->bindValue(1,$frontId,PDO::PARAM_INT);
            $stmt->execute();
            $dict = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            $stmt->closeCursor();

            if($dict['words']) {
                $words = json_decode($dict['words'], true);
                foreach ($words as $k => $v) {

                    $author = $v['author'];
                    if($stmt = $db->prepare(" select imie, nazwisko, avatar from users where id = ? "))
                    {
                        $stmt->bindValue(1, $author, PDO::PARAM_INT);
                        $stmt->execute();
                        $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                        $stmt->closeCursor();
                        $merged = array_merge($v,$user);
                        $words[$k] = $merged;
                    }
                }
                $dict['words'] = $words;
            }
            return $dict;
        }
    }

    global $db;
    global $accessDict;
    $query = " select id,version from dict where $accessDict order by id desc ";
    if($stmt = $db->prepare($query))
    {
        $stmt->bindValue(1,$me,PDO::PARAM_INT);
        $stmt->bindValue(2,$me,PDO::PARAM_INT);
        $stmt->bindValue(3,$vip,PDO::PARAM_INT);
        $stmt->bindValue(4,$me,PDO::PARAM_INT);
        
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        foreach ($tab as $i => $value) { // I'm looking for positions to delete
            $id = $value[0];
            $version = $value[1];
            $notExist = compare2DeteleInDB($id);
            if(!$notExist) { 
                unset($tab[$i]);
                $deletedDicts[] = $id;
            }
        }
        foreach ($tab as $value) { // In modified table I'm looking form smth to edit
            $id = $value[0];
            $version = $value[1];
            $temp = compare2EditInDB($id,$version);
            if($temp) { $updatedDicts[] = $temp; }
        }
        foreach($data as $row) { // back row [id,version]
            $backId = $row['id'];
            $found = false;
            
            foreach($tab as $ele) { // front tab [id,version]
                $frontId = $ele[0];
                if($backId == $frontId) { 
                    $found = true;
                    break;
                }
            }
            if(!$found) {
                $newDicts[] = getDict($backId); // at the end, I'm loocking for smth to add
            }
        }
        echo json_encode(array("news"=>$newDicts,"updated"=>$updatedDicts,"deleted"=>$deletedDicts),JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }
?>