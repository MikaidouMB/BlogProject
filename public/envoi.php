<?php

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD']=='POST') {

    $expediteur = "kenzmhd@gmail.fr";
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = utf8_decode($_POST['message'])."\r\n";


    $destinataire = 'mikaidoumbo@hotmail.fr'; // Adresse email du webmaster (à personnaliser)
    $contenu .= '<p>Tu as un nouveau message !</p>';
    $contenu .= '<p><strong>Nom</strong>: '.$name.'</p>';
    $contenu .= '<p><strong>Prénom</strong>: '.$firstname.'</p>';
    $contenu .= '<p><strong>Email</strong>: '.$email.'</p>';
    $contenu .= '<p><strong>Message</strong>: '.$message.'</p>';
    $contenu .= '<p><strong>Phone</strong>: '.$phone.'</p>';

    $contenu .= '</body></html>';

    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

    mail($destinataire,$contenu,$email,$headers,$message);
    var_dump($_POST);

    //header('Location:index.php');
}

/*
$name = isset($_GET['name']) ? $_GET['name'] : $_POST['name'];
$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : $_POST['firstname'];

$email = isset($_GET['email']) ?$_GET['email'] : $_POST['email'];
$message = isset($_GET['message']) ?$_GET['message'] : $_POST['message'];

if ($_POST) $post=1;

if (!$name) $errors[count($errors)] = 'Please enter your name.';
if (!$firstname) $errors[count($errors)] = 'Please enter your name.';

if (!$email) $errors[count($errors)] = 'Please enter your email.';

$retour = mail('mikaidoumbo@hotmail.fr',
    'Envoi depuis la page Contact',
    $_POST['message'], 'From : webmaster@monsite.fr');
if ($retour) {
    echo '<p>Votre message a bien été envoyé.</p>';
}


//Pour définir chaque input du formulaire, ajouter le signe de dollar devant
/*$msg = "Nom:\t$nom\n";
$msg = "Prénom:\t$prenom\n";
$msg .= "E-Mail:\t$email\n";
$msg .= "Téléphone:\t$telephone\n";
$msg .= "Message:\t$message\n\n";
//Pourait continuer ainsi jusqu'à la fin du formulaire

$recipient = "mikaidoumbo@hotmail.fr";
$subject = "Formulaire";

$mailheaders = "From: Mon test de formulaire<> \n";
$mailheaders .= "Reply-To: $email\n\n";

if (mail($recipient, $subject, $msg, $mailheaders))
{
    echo "Votre message a bien été envoyé.";
}
else
{
    echo "Votre message n'a pas bien été envoyé.";
}


mail($recipient, $subject, $msg, $mailheaders);

echo "<HTML><HEAD>";
echo "<TITLE>Formulaire envoyer!</TITLE></HEAD><BODY>";
echo "<H1 align=center>Merci, $nom </H1>";
echo "<P align=center>";
echo "Votre formulaire à bien été envoyé !</P>";
echo "</BODY></HTML>";

?>jet du mail","Message");*/