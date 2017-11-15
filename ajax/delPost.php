<?php require_once "db.php";

        $post = file_get_contents('php://input');
        $_POST = json_decode($post,true);

	$pid = $_POST['pid'];
	$mid = $_POST['mid'];
	$index = $_POST['index'];
        
	if($pid and $mid)
	{
            global $db;
            if($stmt = $db->prepare(" select attachments from posts where id = ? and kto = ? "))
            {
                $stmt->bindValue(1, $pid, PDO::PARAM_INT);
                $stmt->bindValue(2, $mid, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

                if($result)
                {    
                    $stmt->closeCursor();
                    if($stmt = $db->prepare(" delete from posts where id = ? and kto = ? "))
                    {
                        $stmt->bindValue(1, $pid, PDO::PARAM_INT);
                        $stmt->bindValue(2, $mid, PDO::PARAM_INT);

                        if($stmt->execute()){ 

                            $res = $result['attachments'] = json_decode($result['attachments'], true);
                            if(is_array($res)) {
                                foreach ($res as $val) {
                                    unlink("../".$val['answer']);
                                }
                            }
                            
                            $stmt->closeCursor();
                            if($stmt = $db->prepare(" delete from register where what = 'E' and (type = 'C' or type = 'L' or type = 'P') and link = ? "))
                            {
                                $stmt->bindValue(1, $pid, PDO::PARAM_INT);
                                $stmt->execute();
                            }
                        }

                        $stmt->closeCursor();
                        if($stmt = $db->prepare(" delete from comments where gdzie = ? "))
                        {
                            $stmt->bindValue(1, $pid, PDO::PARAM_INT);
                            $stmt->execute();
                        }
                        $stmt->closeCursor();
                        if($stmt = $db->prepare(" delete from likes where co = ? "))
                        {
                            $stmt->bindValue(1, $pid, PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    }
                }
            }
	}
        echo json_encode($index,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE); // I return index to delete on success
?>