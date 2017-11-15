<?php require_once "db.php";

    $id = $_POST['id'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $from = $_POST['from']; // FB or GP
    $recommendation = $_POST['recommendation'];

    global $db;
    if($stmt = $db->prepare("select count(id) from users where ".$from." = ?")) // czy mam ID?
    {
        $stmt->bindValue(1, $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        $stmt->closeCursor();

        if($count > 0) { // mam ID
            login($id);
        }
        else { // nie mam ID
            if($stmt = $db->prepare("select count(id) from users where email = ?")) { // czy jest email?
                $stmt->bindValue(1, $email, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->fetchColumn();
                $stmt->closeCursor();

                if($count > 0) { // mam email
                    add_login($email,$from,$id);
                }
                else { // nie mam emaila
                    register($first,$last,$email,$from,$id,$recommendation);
                }
            }
        }
    }

    function login($id) {
        global $db;
        
        if($stmt = $db->prepare(" select id, imie, nazwisko, lvl_ang, vip, email, avatar, back, skype, www, about from users where email = ? or FB = ? or GP = ? limit 1 ")) {
            
            $stmt->bindValue(1, $id, PDO::PARAM_STR);
            $stmt->bindValue(2, $id, PDO::PARAM_STR);
            $stmt->bindValue(3, $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            $stmt->closeCursor();
            echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        }
    }

    function add_login($email,$from,$id) {
        global $db;
        
        if($stmt = $db->prepare("select id from users where email = ?")) {
            
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $uid = $stmt->fetchColumn();
            $stmt->closeCursor();

            if($stmt = $db->prepare("update users set ".$from." = ? where id = ?")) {
                
                $stmt->bindValue(1, $id, PDO::PARAM_STR);
                $stmt->bindValue(2, $uid, PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
            }
            login($id);
        }
    }

    function register($first,$last,$email,$from,$id,$recommendation) {
        global $db;
        
        if($stmt = $db->prepare("insert into users set expiration = '9999-12-31', email = ?, imie = ?, nazwisko = ?, ". $from ." = ?, haslo = ?, avatar = ?, back = ?, registred = ?, recommendation = ?, pronunciation = ?, confirmed = 1")) {
            
            $mili = round(microtime(true) * 1000);
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->bindValue(2, $first, PDO::PARAM_STR);
            $stmt->bindValue(3, $last, PDO::PARAM_STR);
            $stmt->bindValue(4, $id, PDO::PARAM_STR);
            $stmt->bindValue(5, md5($from.$id), PDO::PARAM_INT);
            $stmt->bindValue(6, 'img/avatar/default.jpg', PDO::PARAM_STR);
            $stmt->bindValue(7, 'img/avatar/back.jpg', PDO::PARAM_STR);
            $stmt->bindValue(8, $mili, PDO::PARAM_STR);
            $stmt->bindValue(9, $recommendation, PDO::PARAM_INT);
            $stmt->bindValue(10, json_encode(["name"=>"UK English Female","id"=>1],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $cid = $db->lastInsertId();
            if($cid) {
                login($id);
            }
        }
    }

?>