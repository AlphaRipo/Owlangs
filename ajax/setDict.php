<?php require_once "db.php";

    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    
    $me = $_POST['me'];
    $dict = $_POST['dict'];
    $vip1 = intval($me['vip']);
    
    if($dict)
    {
        $dict['date'] = date('Y-m-d H:i:s');
        $dict['nazwisko'] = $me['nazwisko'];
        $dict['avatar'] = $me['avatar'];
        $dict['imie'] = $me['imie'];
        global $db;
        
        if($stmt = $db->prepare(" select count(*) from dict where author = ? ")) {
            $stmt->bindValue(1, $me['id'], PDO::PARAM_INT);
            $stmt->execute();
            $count = intval($stmt->fetchColumn());
            $stmt->closeCursor();
        }
        
        if($stmt = $db->prepare(" select count(*) from users where id = ? and vip = 1 ")) {
            $stmt->bindValue(1, $me['id'], PDO::PARAM_INT);
            $stmt->execute();
            $vip2 = intval($stmt->fetchColumn());
            $stmt->closeCursor();
        }
        
        $status = [];
        
        if($count === 0 || $vip2 === 1) {
            
            $cannot = 0;
        
            $query = " insert into dict set words = ?, title = ?, description = ?, lvl = ?, author = ?, access = ?, date = ? ";
            if($stmt = $db->prepare($query))
            {
                $stmt->bindValue(1, json_encode( array_values( $dict['words'] ), JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE ), PDO::PARAM_STR);
                $stmt->bindValue(2, $dict['title'], PDO::PARAM_STR);
                $stmt->bindValue(3, $dict['description'], PDO::PARAM_STR);
                $stmt->bindValue(4, $dict['lvl'], PDO::PARAM_STR);
                $stmt->bindValue(5, $dict['author'], PDO::PARAM_INT);
                $stmt->bindValue(6, $dict['access'], PDO::PARAM_INT);
                $stmt->bindValue(7, $dict['date'], PDO::PARAM_STR);
                $check = $stmt->execute();
                if($check) { $status[] = "inserted dict"; }
                $stmt->closeCursor();
                $dict['id'] = $db->lastInsertId();

                if($check and $dict['access'] < 3) {

                    if($stmt = $db->prepare(" insert into posts set kto = ?, tresc = ?, data = ?, pv = ?, gdzie = ?, reach = ?, attachments = ?, todo = ? "))
                    {
                        $stmt->bindValue(1, $dict['author'], PDO::PARAM_INT);
                        $stmt->bindValue(2, "Check out my new word lists!", PDO::PARAM_STR);
                        $stmt->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
                        $stmt->bindValue(4, 0, PDO::PARAM_INT);
                        $stmt->bindValue(5, 0, PDO::PARAM_INT);
                        $stmt->bindValue(6, $dict['access'], PDO::PARAM_INT);
                        $stmt->bindValue(7, json_encode([],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                        $stmt->bindValue(8, json_encode(['dname'=>$dict['title'],'did'=>$dict['id']],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                        $check = $stmt->execute();
                        $stmt->closeCursor();
                        if($check) { $pid = $db->lastInsertId(); }
                    }
                    
                    $whom = "'[{\"user\":{\"id\":\"0\",\"seen\":\"0\"}}]'";

                    if($stmt = $db->prepare("insert into register set what = 'E', type = 'W', who = ?, whom = $whom, link = ?, sublink = ?, added = ?"))
                    {
                        $stmt->bindValue(1, $dict['author'], PDO::PARAM_INT);
                        $stmt->bindValue(2, $dict['id'], PDO::PARAM_INT);
                        $stmt->bindValue(3, $pid, PDO::PARAM_INT);
                        $stmt->bindValue(4, $dict['date'], PDO::PARAM_STR);
                        $stmt->execute();
                    }
                }

                // I added to dict and now I'm creating connection in dict_my

                $what = $dict['id'];
                $who = $me['me'];

                if($stmt = $db->prepare("select count(*) from dict_my where who = ? and what = ?"))
                {
                    $stmt->bindValue(1, $who, PDO::PARAM_INT);
                    $stmt->bindValue(2, $what, PDO::PARAM_INT);
                    if($stmt->execute()) { $status[] = "selected dict_my"; }
                    $res = $stmt->fetchColumn();
                    $stmt->closeCursor();

                    if($res == 0) {

                        if($stmt = $db->prepare("insert into dict_my set who = ?, what = ?"))
                        {
                            $stmt->bindValue(1, $who, PDO::PARAM_INT);
                            $stmt->bindValue(2, $what, PDO::PARAM_INT);
                            if($stmt->execute()) { $status[] = "inserted dict_my"; }
                            $stmt->closeCursor();
                        }
                    }
                }
            }
        } else { $cannot = 1; }
        echo json_encode(['cannot'=>$cannot,'status'=>$status,'checkVip'=>( $vip1 == $vip2 )],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }

?>