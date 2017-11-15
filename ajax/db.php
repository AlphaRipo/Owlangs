<?php session_start();

    try { $db = new PDO('mysql:host=mysql4.mydevil.net;dbname=m1310_sowa;charset=utf8','m1310_sowa','1Milion$'); }
    catch (PDOException $e) { echo "Problem z DB"; die(); }

    function dcangaris ($x1) {
        $x2 = stripslashes(preg_replace("/'/",'&#39;',$x1)); // apostrof
        $x3 = stripslashes(preg_replace('/"/','&#34;',$x2)); // cudzyslow
        return ''.$x3;
    }

    function langs ($val) {
        if($val) {
            global $db;
            $stmt = $db->prepare("select count(id) from langs where pl = ?");
            $stmt->bindValue(1, $val, PDO::PARAM_STR);
            $stmt->execute();
            $pid =  $stmt->fetchColumn();
            $stmt->closeCursor();

            if($pid > 0) {
                if($stmt = $db->prepare("select en,pl from langs where pl = ? limit 1")) {
                    $stmt->bindValue(1, $val, PDO::PARAM_STR);
                    $stmt->execute();
                    $line = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();

                    if($line[0]['en']) { return dcangaris($line[0]['en']); }
                    else { return dcangaris($line[0]['pl']); }
                }
            }
            else {
                if($stmt = $db->prepare("insert into langs set pl = ?")) {
                    $stmt->bindValue(1, $val, PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();
                    return dcangaris($val);
                }
            }
        }
    }

    function cnWordWrap ($text) {
        $input = explode(" ",$text);
        foreach ($input as $v) {
            $output[] = wordwrap(trim($v), 25, "-", 1);
        }
        return implode(" ",$output);
    }

    $accessDict = " dict.access = 0 or ( 
        ( select if ( ( select count(*) from friends where ( friends.id_0 = ? and dict.author = friends.id_1 ) or dict.author = ? ) > 0 and dict.access = 1, true, false ) ) or 
        ( select if ( dict.access = 2 and ? > 0, true, false ) ) or 
        ( select if ( dict.access = 3 and dict.author = ?, true, false ) ) ) ";
    
?>