<?php

    if(!isset($_SESSION)) { session_start(); } 
    if(isset($_SESSION['MY_ID'])) $your_id = $_SESSION['MY_ID']; else die('wrong id');

    require_once "db.php";

    if(isset($_FILES["file"]["name"]))
    {
        $file_exts = array("jpg", "jpeg", "gif", "png");
        $upload_exts = end(explode(".", $_FILES["file"]["name"]));
        if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/pjpeg"))
            && ($_FILES["file"]["size"] < 5000000)
            && in_array($upload_exts, $file_exts))
        {
            if($_FILES["file"]["error"] > 0) {}
            else
            {
                $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                $_DIR = "../img/avatar/".$your_id."/";

                if (!file_exists($_DIR)) { mkdir($_DIR, 0755, true); }
                $milis = round(microtime(true) * 10000);
                $new_name = "back_".$milis.".".$ext;
                $all_name = $_DIR . $new_name;

                //-------------------------------------------

                $images = glob($_DIR . "back_*.*");
                foreach ($images as $image){ unlink($image); }

                //-------------------------------------------

                move_uploaded_file($_FILES["file"]["tmp_name"],$all_name);

                //-------------------------------------------

                if($ext == "jpg" or $ext == "jpeg") $zdjecie = imagecreatefromjpeg($all_name);
                elseif($ext == "png") $zdjecie = imagecreatefrompng($all_name);
                elseif($ext == "gif") $zdjecie = imagecreatefromgif($all_name);

                $x = imagesx($zdjecie);
                $y = imagesy($zdjecie);

                $final_x = $x;
                $final_y = $y;
                $tmp_x = 0;
                $tmp_y = 0;

                if($y<$x) $tmp_x = ceil(($x-$final_x*$y/$final_y)/2);
                elseif($x<$y) $tmp_y = ceil(($y-$final_y*$x/$final_x)/2);

                $nowe_zdjecie = imagecreatetruecolor($final_x, $final_y); 
                imagecopyresampled($nowe_zdjecie, $zdjecie, 0, 0, $tmp_x, $tmp_y, $final_x, $final_y, $x-2*$tmp_x, $y-2*$tmp_y);
                imagejpeg($nowe_zdjecie, $all_name, 85);

                //-------------------------------------------

                global $db;
                if($stmt = $db->prepare(" update users set back = ? where id = ? ")) 
                {
                    $stmt->bindValue(1, substr($all_name, 3), PDO::PARAM_STR);
                    $stmt->bindValue(2, $your_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->closeCursor();
                    echo json_encode( array("file"=>substr($all_name, 3),"me"=>$your_id), JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }

?>