<?php require_once "db.php";

        $mid = $_POST['mid'];
        $date = date("Y-m-d");
        $type = $_POST['obj']['type'];
        $price = $_POST['obj']['price'];
        $content = $_POST['obj']['content'];
        $category = $_POST['obj']['category'];
        $currency = $_POST['obj']['currency'];
        $title = $_POST['obj']['title'];
        $term = $_POST['obj']['term'];

        $parts = explode('-', $term);
        $term  = $parts[2]."-".$parts[1]."-".$parts[0];

        global $db;
        if($stmt = $db->prepare("insert into auctions set user = ?, title = ?, currency = ?, content = ?, price = ?, term = ?, date = ?, category = ?, type = ? "))
        {
                $stmt->bindValue(1, $mid,PDO::PARAM_INT);
                $stmt->bindValue(2, $title,PDO::PARAM_INT);
                $stmt->bindValue(3, $currency,PDO::PARAM_STR);
                $stmt->bindValue(4, $content,PDO::PARAM_STR);
                $stmt->bindValue(5, $price,PDO::PARAM_STR);
                $stmt->bindValue(6, $term,PDO::PARAM_STR);
                $stmt->bindValue(7, $date,PDO::PARAM_STR);
                $stmt->bindValue(8, $category,PDO::PARAM_STR);
                $stmt->bindValue(9, $type,PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
        }
?>