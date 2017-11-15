<?php require_once "db.php";

        $mid = $_POST['mid'];
        $date = date("Y-m-d");
        $price = $_POST['obj']['price'];
        $content = $_POST['obj']['content'];
        $currency = $_POST['obj']['currency'];
        $auction = $_POST['obj']['auction'];
        $title = $_POST['obj']['title'];
        $term = $_POST['obj']['term'];

        $parts = explode('-', $term);
        $term  = $parts[2]."-".$parts[1]."-".$parts[0];

        global $db;
        if($stmt = $db->prepare("insert into auctions_offers set who = ?, title = ?, currency = ?, content = ?, price = ?, term = ?, date = ?, auction = ? "))
        {
                $stmt->bindValue(1, $mid,PDO::PARAM_INT);
                $stmt->bindValue(2, $title,PDO::PARAM_STR);
                $stmt->bindValue(3, $currency,PDO::PARAM_STR);
                $stmt->bindValue(4, $content,PDO::PARAM_STR);
                $stmt->bindValue(5, $price,PDO::PARAM_STR);
                $stmt->bindValue(6, $term,PDO::PARAM_STR);
                $stmt->bindValue(7, $date,PDO::PARAM_STR);
                $stmt->bindValue(8, $auction,PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
        }
?>