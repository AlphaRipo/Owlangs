<?php require_once "db.php";

    $_PL = $_SESSION['payLane']; // IMPORTANT !!!
    $post = file_get_contents('php://input');
    $_POST = json_decode($post,true);
    $me = $_POST['me']['id'];

    if($me and $_PL['hash'] and $_PL['id_sale'])
    {
        global $db;
        if($stmt = $db->prepare(" update users set vip = 1, expiration = ADDDATE(expiration, INTERVAL 31 DAY) where id = ? "))
        {
            $stmt->bindValue(1, $me, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

            if($stmt = $db->prepare(" insert into payments set payLaneID = ?, payLaneHash = ?, payLaneCurrency = ?, payLaneAmount = ?, payLaneDescription = ?, payLaneStatus = ?, userID = ?, paymentDate = ? "))
            {
                $stmt->bindValue(1, $_PL['id_sale'], PDO::PARAM_STR);
                $stmt->bindValue(2, $_PL['hash'], PDO::PARAM_STR);
                $stmt->bindValue(3, $_PL['currency'], PDO::PARAM_STR);
                $stmt->bindValue(4, $_PL['amount'], PDO::PARAM_STR);
                $stmt->bindValue(5, $_PL['description'], PDO::PARAM_STR);
                $stmt->bindValue(6, $_PL['status'], PDO::PARAM_STR);
                $stmt->bindValue(7, $me, PDO::PARAM_INT);
                $stmt->bindValue(8, date('Y-m-d H:i:s'), PDO::PARAM_STR);
                if($stmt->execute()) { 
                    session_unset();
                    echo "done";
                }
                $stmt->closeCursor();
            }
            else { echo "query 2"; }
        }
        else { echo "query 1"; }
    }
    else { echo "no data"; }
    
    ?>