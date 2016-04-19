<?php

// get posted data into local variables
$email_to = bloginfo('admin_email');
$name = trim(stripslashes(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING))); 
$email_from = trim(stripslashes(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))); 
$subject = "[ProperWeb]: " . trim(stripslashes(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING))); 
$subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
$company = trim(stripslashes(filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING))); 
$phone = trim(stripslashes(filter_input(INPUT_POST, 'phone'))); 
$message = 
    '\nCompany: '.$company.
    '\nContact number: '.$phone.
    '\nMessage:\n'.trim(stripslashes(filter_input(INPUT_POST, 'message'))); 
$referer = filter_input(INPUT_POST, 'referer', FILTER_VALIDATE_URL);
$userip = ($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$headers  = 'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";  

print "$message"; exit;
/*
// send email  
$success = mail($email_to, $subject, $message, $headers
			. "From: =?utf-8?b?" . base64_encode($name) . "?= <" . $email_from . ">\r\n"
      . "X-Mailer: PHP/" . phpversion() . "\r\n"
      . "X-From-IP: " . $userip);
 
if ($success) {
  print "<meta http-equiv=\"refresh\" content=\"0; url=http://domstil.com.ua/?message=ok\">";
}
else {
  print "<meta http-equiv=\"refresh\" content=\"0; url=http://domstil.com.ua/?message=error\">";
}
*/
?>