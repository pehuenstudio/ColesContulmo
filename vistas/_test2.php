<?php
//require_once $_SERVER["DOCUMENT_ROOT"]."/_code/vistas/carga_evaluaciones.vista.php";
$to       = 'rodrigo.sepulveda@gmail.com';
$subject  = 'Testing sendmail.exe';
$message  = 'Hi, you just received an email using sendmail!';
$headers  = 'From: [your_gmail_account_username]@gmail.com' . "\r\n" .
    'MIME-Version: 1.0' . "\r\n" .
    'Content-type: text/html; charset=utf-8';
if(mail($to, $subject, $message, $headers))
    echo "Email sent";
else
    echo "Email sending failed";
?>
 