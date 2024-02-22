<?php

 $message = "Chena chena chena bangi.";

 $to = 'chester.sigua@westfields.edu.ph';
 $subject = 'Congratulations on choosing Westfields!';
 $from = 'no-reply@westfields.edu.ph';
 
 $headers  = 'MIME-Version: 1.0' . "\r\n";
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
 $headers .= 	'From: '.$from."\r\n".
        		'Reply-To: '.$from."\r\n" .
        		'X-Mailer: PHP/' . phpversion();

if(mail($to, $subject, $message, $headers,'-f no-reply@westfields.edu.ph -F "Westfields Admissions"')){
	echo 'Your mail has been sent successfully.';
	die();
} else{
    echo 'fail';
	die();
}