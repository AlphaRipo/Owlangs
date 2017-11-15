<?php

    $msg = $_POST['msg'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    if($msg and $name and $email)
    {
        if(strlen($name) < 1 ){ echo 'error_name_len'; }
        else if(strlen($email) < 1 ) { echo 'error_email_len'; }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { echo 'wrong_email_error'; }
        else if(strlen($msg) < 1 ){ echo 'error_msg_len'; }
        else 
        {
            $email_message = "Nazwa : " . $name . "<br> E-mail : " . $email . "<br> Wiadomość : " . $msg;
            $email_message = trim(stripslashes($email_message));

            mail("biuro@newfuture.company", "Kontakt z OWLANGS.COM", $email_message, "From: ".$name." <".$email.">\r\n"."Content-type: text/html; charset=UTF-8"."\r\n"."Reply-To: ".$email."\r\n"."X-Mailer: PHP/" . phpversion());
            echo "sent";
        }
    }
?>