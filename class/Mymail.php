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
            $mail->Host       = '*********';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = '**************';                     // SMTP username
            $mail->Password   = '*************';                               // SMTP password
            $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('*********************', 'Equipe Diário Mágico');
            $mail->addAddress($address, $recipient);     // Add a recipient
        

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

