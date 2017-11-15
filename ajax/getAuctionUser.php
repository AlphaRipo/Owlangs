<?php
        ob_start();
        try { $db = new PDO('mysql:host=mysql4.mydevil.net;dbname=m1310_sowa;charset=utf8','m1310_sowa','Caesaris13081989'); }
        catch (PDOException $e) { echo "Problem z DB"; die(); }

        $user = $_POST['user'];

        global $db;
        if($stmt = $db->prepare("select imie, nazwisko, lvl_ang from users where id = ?"))
        {
                $stmt->bindValue(1, $user,PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
                echo json_encode($result,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
        }
?>