<?php

require  'PHPMailer/Exception.php' ;
require  'PHPMailer/PHPMailer.php' ;
require  'PHPMailer/SMTP.php' ;

use App\Model\GetValue;
use PHPMailer\PHPMailer\PHPMailer;

$name = filter_input(INPUT_POST, 'name');
$firstName = filter_input(INPUT_POST, 'firstname');
$email =filter_input(INPUT_POST, 'email');
$subject = filter_input(INPUT_POST, 'subject');
;

$mail = new PHPMailer ;

$mail->isSMTP ();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true ;
$mail->Username = 'mikaidoumbo92@gmail.com' ;
$mail->Password = 'istbwblincmnmsph' ;
$mail->SMTPSecure = 'tls' ;
$mail->Port = 587 ;

$mail->FromName = $name ;
$mail->Body = "nom : $name <br>". "prenom : $firstName <br> " . "sujet : $subject <br>" . "email : $email";

$message = file_get_contents('envoi.php');
$name = str_replace('%name%', $name, $message);
$firstName = str_replace('%firstname%', $firstName, $message);
$message = str_replace('%subject%', $subject, $message);

$mail->setFrom ( $email );

$mail->addAddress ( 'mikaidoumbo92@gmail.com' );
$mail->isHTML ( true );

$mail->Subject = 'Formulaire du portfolio';

 if(! $mail->send ()) {
    print_r('Le message n"a pas pu être envoyé. Erreur de courrier : ' . $mail->ErrorInfo);
} else{
     header('Location: index.php');
     GetValue::exitMessage();
 }

