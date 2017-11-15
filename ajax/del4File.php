<?php

    $name = $_POST['name'];
    if($name)
    {
    	unlink('http://owlangs.com/video/'+$name+'.mp4');
    	unlink('http://owlangs.com/video/'+$name+'.jpg');
    }
	
?>