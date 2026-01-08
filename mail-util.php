<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmails($formData, $files = []) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST');
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER');
        $mail->Password   = getenv('SMTP_PASS');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = getenv('SMTP_PORT');
        $mail->CharSet    = 'UTF-8';

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
        $confirmMail->Host       = getenv('SMTP_HOST');
        $confirmMail->SMTPAuth   = true;
        $confirmMail->Username   = getenv('SMTP_USER');
        $confirmMail->Password   = getenv('SMTP_PASS');
        $confirmMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $confirmMail->Port       = getenv('SMTP_PORT');
        $confirmMail->CharSet    = 'UTF-8';

        $confirmMail->setFrom('contact@modelacademy-management.com', 'Models Academy Management');
        $confirmMail->addAddress($formData['email']);
        $confirmMail->Subject = 'Confirmation de réception – Models Academy Management';
        $confirmMail->Body    = "Nous avons reçu votre demande avec succès.\n\nSi vous n'obtenez pas de réponse après cinq (5) jours, cela signifie que votre demande n'a pas été acceptée.\n\nModels Academy Management";

        $confirmMail->send();

        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>