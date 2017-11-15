<?php

    if(!empty($_FILES)) {
        
        $mid = filter_input(INPUT_GET,'mid');
        $context = filter_input(INPUT_GET,'context');
        
        $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
        $ext = pathinfo( $_FILES[ 'file' ][ 'name' ] , PATHINFO_EXTENSION);
        
        $mili = round(microtime(true) * 10000); // mili * 10
        $pathA = '..'.DIRECTORY_SEPARATOR;
        $pathB = 'img'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR.$mid;
        $pathC = DIRECTORY_SEPARATOR.$mili.'_'.$_FILES[ 'file' ][ 'name' ];

        if (!file_exists($pathA.$pathB)) {
            mkdir($pathA.$pathB, 0777, true);
        }
        move_uploaded_file( $tempPath, $pathA.$pathB.$pathC );
        
        //-------------------------------------------

        if($context == 'PROFILE') {
            
            if($ext == "jpg" or $ext == "jpeg") { $zdjecie = imagecreatefromjpeg($pathA.$pathB.$pathC); }
            elseif($ext == "png") { $zdjecie = imagecreatefrompng($pathA.$pathB.$pathC); }
            elseif($ext == "gif") { $zdjecie = imagecreatefromgif($pathA.$pathB.$pathC); }

            $x = imagesx($zdjecie);
            $y = imagesy($zdjecie);

            $final_x = 220;
            $final_y = 220;
            $tmp_x = 0;
            $tmp_y = 0;

            if($y<$x) { $tmp_x = ceil(($x-$final_x*$y/$final_y)/2); }
            elseif($x<$y) { $tmp_y = ceil(($y-$final_y*$x/$final_x)/2); }

            $nowe_zdjecie = imagecreatetruecolor($final_x, $final_y); 
            imagecopyresampled($nowe_zdjecie, $zdjecie, 0, 0, $tmp_x, $tmp_y, $final_x, $final_y, $x-2*$tmp_x, $y-2*$tmp_y);
            imagejpeg($nowe_zdjecie, $pathA.$pathB.$pathC, 85);
        }

        //-------------------------------------------

        if($context == 'BACKGROUND') {
        
            if($ext == "jpg" or $ext == "jpeg") { $zdjecie = imagecreatefromjpeg($pathA.$pathB.$pathC); }
            elseif($ext == "png") { $zdjecie = imagecreatefrompng($pathA.$pathB.$pathC); }
            elseif($ext == "gif") { $zdjecie = imagecreatefromgif($pathA.$pathB.$pathC); }

            $x = imagesx($zdjecie);
            $y = imagesy($zdjecie);

            $final_x = $x;
            $final_y = $y;
            $tmp_x = 0;
            $tmp_y = 0;

            if($y<$x) { $tmp_x = ceil(($x-$final_x*$y/$final_y)/2); }
            elseif($x<$y) { $tmp_y = ceil(($y-$final_y*$x/$final_x)/2); }

            $nowe_zdjecie = imagecreatetruecolor($final_x, $final_y); 
            imagecopyresampled($nowe_zdjecie, $zdjecie, 0, 0, $tmp_x, $tmp_y, $final_x, $final_y, $x-2*$tmp_x, $y-2*$tmp_y);
            imagejpeg($nowe_zdjecie, $pathA.$pathB.$pathC, 85);
        }

        //-------------------------------------------
        
        echo json_encode( array('answer' => $pathB.$pathC) );
        
        //-------------------------------------------

    } else { echo 'No files'; }

?>