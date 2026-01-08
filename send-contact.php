<?php
require 'mail-util.php';

$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$sujet = $_POST['sujet'] ?? '';
$message = $_POST['message'] ?? '';

$body = "MESSAGE DE CONTACT - MODELS ACADEMY MANAGEMENT\n\n";
$body .= "NOM: $nom\n";
$body .= "EMAIL: $email\n";
$body .= "SUJET: $sujet\n\n";
$body .= "MESSAGE:\n$message\n";

$formData = [
    'email' => $email,
    'nom' => $nom,
    'subject_line' => "Nouveau message de contact - $nom",
    'body_content' => $body
];

if (sendEmails($formData)) {
    echo json_encode(['success' => true, 'message' => 'Nous avons bien reçu vos informations. Merci pour votre candidature.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi.']);
}
?>