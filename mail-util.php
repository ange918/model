<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmails($formData, $files = []) {
    $mail = new PHPMailer(true);
    try {
        // Paramètres SMTP directement intégrés pour l'hébergement
        $mail->isSMTP();
        $mail->Host       = 'mail.modelacademy-management.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact@modelacademy-management.com';
        $mail->Password   = '91rerdakonde';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Recipients
        $mail->setFrom('contact@modelacademy-management.com', 'Models Academy Management');
        $mail->addAddress('contact@modelacademy-management.com');
        $mail->addCC('modelacademymgnt@gmail.com');
        $mail->addReplyTo($formData['email'], $formData['nom'] ?? ($formData['prenom'] . ' ' . $formData['nom']));

        // Attachments
        foreach ($files as $name => $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                $mail->addAttachment($file['tmp_name'], $file['name']);
            }
        }

        // Content
        $mail->isHTML(false);
        $mail->Subject = $formData['subject_line'];
        $mail->Body    = $formData['body_content'];

        $mail->send();

        // Confirmation to User
        $confirmMail = new PHPMailer(true);
        $confirmMail->isSMTP();
        $confirmMail->Host       = 'mail.modelacademy-management.com';
        $confirmMail->SMTPAuth   = true;
        $confirmMail->Username   = 'contact@modelacademy-management.com';
        $confirmMail->Password   = '91rerdakonde';
        $confirmMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $confirmMail->Port       = 465;
        $confirmMail->CharSet    = 'UTF-8';
        $confirmMail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $confirmMail->setFrom('contact@modelacademy-management.com', 'Models Academy Management');
        $confirmMail->addAddress($formData['email']);
        $confirmMail->Subject = 'Confirmation de réception – Models Academy Management';
        $confirmMail->isHTML(true);
        
        $htmlBody = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;'>
            <div style='text-align: center; margin-bottom: 20px;'>
                <h2 style='color: #333; text-transform: uppercase; letter-spacing: 2px;'>Models Academy Management</h2>
            </div>
            <div style='color: #555; line-height: 1.6;'>
                <p>Bonjour,</p>
                <p>Nous avons reçu votre demande avec succès.</p>
                <p style='background-color: #f9f9f9; padding: 15px; border-left: 4px solid #333;'>
                    Si vous n'obtenez pas de réponse après cinq (5) jours, cela signifie que votre demande n'a pas été acceptée.
                </p>
                <p style='margin-top: 30px;'>Cordialement,<br><strong>Models Academy Management</strong></p>
            </div>
            <div style='margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #999; text-align: center;'>
                &copy; " . date('Y') . " Models Academy Management. Tous droits réservés.
            </div>
        </div>";
        
        $confirmMail->Body = $htmlBody;
        $confirmMail->AltBody = "Nous avons reçu votre demande avec succès.\n\nSi vous n'obtenez pas de réponse après cinq (5) jours, cela signifie que votre demande n'a pas été acceptée.\n\nModels Academy Management";

        $confirmMail->send();

        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>