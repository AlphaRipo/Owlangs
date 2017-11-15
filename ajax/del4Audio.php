<?php

	$name = $_POST['name'];
	if($name) unlink('../'.$name);

?>