<?php require_once "db.php";
    
    $email = $_POST['email'];
    $password = $_POST['haslo'];

    if($email and $password)
    {
        global $db;
        if($stmt = $db->prepare("select count(id) from users where email = ? limit 1"))
        {
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $stmt->closeCursor();

            if($count > 0)
            {
                if($stmt = $db->prepare("select * from users where email = ? limit 1"))
                {
                    $stmt->bindValue(1, $email, PDO::PARAM_STR);
                    $stmt->execute();
                    $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                    $stmt->closeCursor();

                    if($user['haslo'] == $password and $user['email'] == $email)
                    {
                        if($user['confirmed'] == 1) {
                            
                            if($stmt = $db->prepare(" select id, imie, nazwisko, lvl_ang, vip, email, avatar, back, skype, www, pronunciation, about from users where email = ? limit 1 "))
                            {
                                $stmt->bindValue(1, $email, PDO::PARAM_STR);
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                                $stmt->closeCursor();
                                echo json_encode(["user"=>$result,"status"=>"OK"],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
                            }
                        }
                        else { echo json_encode(["status"=>"CONFIRM"],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE); }
                    }
                    else { echo json_encode(["status"=>"PASS"],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE); }
                }
            }
            else { echo json_encode(["status"=>"NONE"],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE); }
        }
    }

?>