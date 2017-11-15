<?php
	
	if(!isset($_SESSION)) { session_start(); } 
	
	if( isset($HTTP_RAW_POST_DATA))
	{
		$cad = $HTTP_RAW_POST_DATA;
		$stringas = explode(":",$cad);
		$type = explode(";", $stringas[1]);
		$base = explode(",", $type[1]);
		$base64 = $base[1];

		if(isset($_SESSION['MY_ID'])) $mid = $_SESSION['MY_ID'];
		else $mid = "0";

		$milis = round(microtime(true) * 10000);
		$myFile = "uploads/" . $milis ."_". $mid .".wav";

		$fh = fopen("../" . $myFile, 'w');
		fwrite($fh, base64_decode($base64));
		echo $myFile;
	}

?>