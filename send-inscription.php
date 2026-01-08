<?php
require 'mail-util.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

$prenom = $_POST['prenom'] ?? '';
$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';

$body = "FORMULAIRE D'INSCRIPTION - MODELS ACADEMY MANAGEMENT\n\n";
foreach ($_POST as $key => $value) {
    $body .= strtoupper($key) . ": " . $value . "\n";
}

$formData = [
    'email' => $email,
    'nom' => $nom,
    'prenom' => $prenom,
    'subject_line' => "Nouvelle inscription - $prenom $nom",
    'body_content' => $body
];

if (sendEmails($formData, $_FILES)) {
    echo json_encode(['success' => true, 'message' => 'Nous avons bien reçu vos informations. Merci pour votre candidature.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi.']);
}
?>