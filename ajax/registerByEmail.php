<?php require_once "db.php";
    
    session_start();

    $recommendation = $_POST['recommendation'];
    $email = strtolower($_POST['email']);
    $first_name = $_POST['imie'];
    $password = $_POST['haslo'];

    if(isset($first_name) and isset($email) and isset($password))
    {
        global $db;
        if($stmt = $db->prepare("select count(id) from users where email = ? "))
        {
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $stmt->closeCursor();

            if($count == 0)
            {
                if($stmt = $db->prepare("insert into users set expiration = '9999-12-31', imie = ?, vip = 0, haslo = ?, email = ?, avatar = ?, back = ?, registred = ?, code = ?, recommendation = ?, pronunciation = ?, confirmed = 0"))
                {
                    $code = generateRandomString();
                    $mili = round(microtime(true) * 1000);
                    $stmt->bindValue(1, $first_name, PDO::PARAM_STR);
                    $stmt->bindValue(2, $password, PDO::PARAM_STR);
                    $stmt->bindValue(3, $email, PDO::PARAM_STR);
                    $stmt->bindValue(4, 'img/avatar/default.jpg', PDO::PARAM_STR);
                    $stmt->bindValue(5, 'img/avatar/back.jpg', PDO::PARAM_STR);
                    $stmt->bindValue(6, $mili, PDO::PARAM_STR);
                    $stmt->bindValue(7, $code, PDO::PARAM_STR);
                    $stmt->bindValue(8, $recommendation, PDO::PARAM_INT);
                    $stmt->bindValue(9, json_encode(["name"=>"UK English Female","id"=>1],JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();

                    $cid = $db->lastInsertId();
                    if($cid)
                    {
                        if($stmt = $db->prepare(" select id, imie, nazwisko, lvl_ang, vip, email, avatar, back, skype, www, about from users where email = ? or FB = ? or GP = ? limit 1 "))
                        {
                            $stmt->bindValue(1, $email, PDO::PARAM_STR);
                            $stmt->bindValue(2, $email, PDO::PARAM_STR);
                            $stmt->bindValue(3, $email, PDO::PARAM_STR);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                            $stmt->closeCursor();
                            echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
                        }

                        $name = ucwords($first_name); 
                        $subject = "OWLANGS.COM - Rejestracja pomyślna!";
                        $from = "info@owlangs.com";

                        if(strlen($name) < 1 ) {}
                        else if(strlen($email) < 1 ) {}
                        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {}
                        else 
                        {
                            $code = "owlangs.com/login_".$cid."_".$code;
                            $email_message = "Cześć " .ucwords($name). ", udało Ci się założyć konto na owlangs.com,<br><br>Twój login to: " . strtolower($email) . "<br>Hasło ze względów bezpieczeństwa nie jest wymysłane automatycznie, możesz natomiast napisać do nas z tego e-maila (e-maila rejestracyjnego) z prośbą o przypomnienie hasła.<br><br>Konto jest jeszcze nie aktywne - kliknij link by aktywować: ".$code;
                            $email_message = trim(stripslashes($email_message));

                            mail($email, $subject, $email_message, "From: ".ucwords($name)." <".$from.">\r\n"."Content-type: text/html; charset=UTF-8"."\r\n"."Reply-To: ".$from."\r\n"."X-Mailer: PHP/" . phpversion());
                        }
                    }
                }
            }
        }
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) { $randomString .= $characters[rand(0, $charactersLength - 1)]; }
        return $randomString;
    }

?>