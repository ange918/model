<?php
// Configuration SMTP - À remplir manuellement
$smtp_config = [
    'host' => '', // À remplir: smtp.gmail.com, etc.
    'port' => 587, // À remplir: 587, 465, etc.
    'username' => '', // À remplir: votre email
    'password' => '', // À remplir: votre mot de passe ou clé app
    'from_email' => '', // À remplir: email d'envoi
    'to_email' => '' // À remplir: email destinataire (agence)
];

// Vérifier que le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Fonction pour nettoyer et valider les données
function sanitizeInput($data, $type = 'text') {
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    if ($type === 'email') {
        $data = filter_var($data, FILTER_SANITIZE_EMAIL);
    }
    
    return $data;
}

try {
    // Récupérer et nettoyer les données du formulaire
    $nom = sanitizeInput($_POST['nom'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '', 'email');
    $telephone = sanitizeInput($_POST['telephone'] ?? '');
    $sujet = sanitizeInput($_POST['sujet'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    
    // Validation basique
    if (empty($nom) || empty($email) || empty($sujet) || empty($message)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Les champs obligatoires sont manquants']);
        exit;
    }
    
    // Validation email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email invalide']);
        exit;
    }
    
    // Créer le contenu de l'email
    $emailContent = "MESSAGE DE CONTACT - MODELS ACADEMY MANAGEMENT\n";
    $emailContent .= "=".str_repeat("=", 60)."\n\n";
    
    $emailContent .= "NOM: $nom\n";
    $emailContent .= "EMAIL: $email\n";
    if (!empty($telephone)) {
        $emailContent .= "TÉLÉPHONE: $telephone\n";
    }
    $emailContent .= "SUJET: $sujet\n\n";
    
    $emailContent .= "MESSAGE:\n";
    $emailContent .= "-".str_repeat("-", 30)."\n";
    $emailContent .= "$message\n\n";
    
    $emailContent .= "=".str_repeat("=", 60)."\n";
    $emailContent .= "Date du message: ".date('Y-m-d H:i:s')."\n";
    
    // En-têtes email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "From: " . $smtp_config['from_email'] . "\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    $subject = "Nouveau message de contact - $nom";
    
    // IMPORTANT: Configuration SMTP requise
    if (empty($smtp_config['host']) || 
        empty($smtp_config['username']) || 
        empty($smtp_config['password']) ||
        empty($smtp_config['from_email']) ||
        empty($smtp_config['to_email'])) {
        
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'message' => 'La configuration SMTP n\'est pas complète. Veuillez remplir les paramètres SMTP dans send-contact.php (host, port, username, password, from_email, to_email)'
        ]);
        exit;
    }
    
    // Utiliser mail() pour envoyer l'email
    if (mail($smtp_config['to_email'], $subject, $emailContent, $headers)) {
        http_response_code(200);
        echo json_encode([
            'success' => true, 
            'message' => 'Message reçu avec succès! Nous vous répondrons dans les plus brefs délais.'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'message' => 'Erreur lors de l\'envoi du message. Veuillez réessayer.'
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Erreur serveur: ' . htmlspecialchars($e->getMessage())
    ]);
}
?>
