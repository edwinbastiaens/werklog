<?php

class Mailer
{
    public static function sendMail($email,$subject,$message)
    {
        $headers  = "MIME-Version: 1.0\r\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	    $headers .= "From: Tolima<info@tolima.be>\r\n";
        mail($email, $subject, $message, $headers);    
    }
}
