<?php

  //------------------------------
  
  $_ERR = null;
  $_RET = array();
  $_MID = $_POST['mid'];
  $_FILES_FROM_FORM = $_FILES['file'];

  if(isset($_FILES_FROM_FORM))
  {
    $count = count($_FILES_FROM_FORM["name"]);
    for($i = 0; $i < $count; $i++)
    {
      $_RET[$i] = save($_FILES_FROM_FORM,$_MID,$i);
    }
  }
  else { $_ERR = "NODATA"; }

  echo json_encode(array("AV" => array_filter($_RET), "ERROR" => $_ERR)); // delete null

  //------------------------------

  function save($_MY_FILE,$_MID,$j)
  {
    $_VAL = null;
    $_MILISEC = round(microtime(true) * 10000); // mili * 10
    
    $_NORMAL_NAME = $_MY_FILE["name"][$j];
    $_TEMP_NAME = $_MY_FILE["tmp_name"][$j];
    
    $_PATH_PART = pathinfo($_NORMAL_NAME);
    $_NEW_NAME = $_MILISEC."_".$_MID.".".$_PATH_PART['extension'];

    $ALLOW_EXT = array("mp3", "mp4", "wma", "wav");
    $_EXT = pathinfo($_NORMAL_NAME, PATHINFO_EXTENSION);

    $_SIZE = $_MY_FILE["size"][$j];
    $_TYPE = $_MY_FILE["type"][$j];

    if ((( $_TYPE == "video/mp4") 
      || ($_TYPE == "audio/mp3") 
      || ($_TYPE == "audio/wma") 
      || ($_TYPE == "audio/wav")) 
      && ($_SIZE < 300000000) // 300mb max
      && in_array( $_EXT, $ALLOW_EXT )) 
    {
      if ($_MY_FILE["error"][$j] > 0) { $_ERR = "ERROR"; }
      else
      {
        if (file_exists("../uploads/" . $_NEW_NAME)) { $_ERR = "EXIST"; }
        else
        {
          move_uploaded_file($_TEMP_NAME, "../uploads/" . $_NEW_NAME);
          $_VAL = "uploads/" . $_NEW_NAME;
        }
      }
    }
    else { $_ERR = "INVALID"; }
    return $_VAL;
  }

  //------------------------------

?>