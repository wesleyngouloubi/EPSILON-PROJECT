<?php 
// Sert à envoyer des mails 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';


function sendmail($subject, $body, $sender, $senderName){

    try {

        $mail = new PHPMailer(true);
        // Configuration
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Donne des infos de débug 

        // Config du SMTP 
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'epsylon.fwk@gmail.com';
        $mail->Password = 'jdnlauktglnhvpot'; // jdnlauktglnhvpot
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Charset
        $mail->CharSet = "UTF-8";

        // Envoie du mail 
        $mail->addAddress($sender, $senderName); // Destinataire
        $mail->setFrom("epsylon.fwk@gmail.com"); // Expéditeur

        // Le contenu 
        $mail->isHTML();
        $mail->Subject = $subject; // Objet du mail
        $mail->Body = $body;
        //$mail->AltBody = ""; // Pour les personnes avec HTML error en text brut

        // L'envoi
        $mail->send();
        // echo "Message Envoyé"; // A voir si changement après le message

    } catch (Exception) {
        $error[] = "Message non envoyé ! Erreur : {$mail->ErrorInfo}";

    }

    $mail->smtpClose();

}

sendmail($subject, $body, $sender, $senderName);