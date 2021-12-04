<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



class Mymail 
{
    public static function sentMail($address, $recipient, $subject, $message, $altMessage)
    {
         require 'PHPMailer/src/Exception.php';
         require 'PHPMailer/src/PHPMailer.php';
         require 'PHPMailer/src/SMTP.php';
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            /* $mail->SMTPDebug = 2;      */                // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'ns926.hostgator.com.br';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'contato@odiariomagico.com.br';                     // SMTP username
            $mail->Password   = 'Rodka&Enoc02';                               // SMTP password
            $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('contato@odiariomagico.com.br', 'Equipe Diário Mágico');
            $mail->addAddress($address, $recipient);     // Add a recipient
            /* $mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com'); */

            // Attachments
            /* $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name */

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $altMessage;
            
            $mail->send();
            //echo 'Email Enviado';
        } catch (Exception $e) {
            //echo "O email não pôde ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
            }
        }
        

?>

