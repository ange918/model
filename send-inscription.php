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

// Récupérer et nettoyer les données du formulaire
try {
    // Étape 1: Informations Personnelles
    $prenom = sanitizeInput($_POST['prenom'] ?? '');
    $nom = sanitizeInput($_POST['nom'] ?? '');
    $date_naissance = sanitizeInput($_POST['date_naissance'] ?? '', 'date');
    $sexe = sanitizeInput($_POST['sexe'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '', 'email');
    $telephone = sanitizeInput($_POST['telephone'] ?? '');
    $adresse = sanitizeInput($_POST['adresse'] ?? '');
    $ville = sanitizeInput($_POST['ville'] ?? '');
    $code_postal = sanitizeInput($_POST['code_postal'] ?? '');
    
    // Étape 2: Expérience & Motivation
    $formation = sanitizeInput($_POST['formation'] ?? '');
    $experience = sanitizeInput($_POST['experience'] ?? '');
    $book = sanitizeInput($_POST['book'] ?? '');
    $motivation = sanitizeInput($_POST['motivation'] ?? '');
    $objectifs = sanitizeInput($_POST['objectifs'] ?? '');
    
    // Étape 3: Mensurations
    $taille = sanitizeInput($_POST['taille'] ?? '');
    $poids = sanitizeInput($_POST['poids'] ?? '');
    $tour_poitrine = sanitizeInput($_POST['tour_poitrine'] ?? '');
    $tour_taille = sanitizeInput($_POST['tour_taille'] ?? '');
    $tour_hanches = sanitizeInput($_POST['tour_hanches'] ?? '');
    $pointure = sanitizeInput($_POST['pointure'] ?? '');
    $couleur_yeux = sanitizeInput($_POST['couleur_yeux'] ?? '');
    $couleur_cheveux = sanitizeInput($_POST['couleur_cheveux'] ?? '');
    $particularites = sanitizeInput($_POST['particularites'] ?? '');
    
    // Validation basique
    if (empty($prenom) || empty($nom) || empty($email)) {
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
    $emailContent = "FORMULAIRE D'INSCRIPTION - MODELS ACADEMY MANAGEMENT\n";
    $emailContent .= "=".str_repeat("=", 60)."\n\n";
    
    $emailContent .= "INFORMATIONS PERSONNELLES\n";
    $emailContent .= "-".str_repeat("-", 30)."\n";
    $emailContent .= "Prénom: $prenom\n";
    $emailContent .= "Nom: $nom\n";
    $emailContent .= "Date de naissance: $date_naissance\n";
    $emailContent .= "Sexe: $sexe\n";
    $emailContent .= "Email: $email\n";
    $emailContent .= "Téléphone: $telephone\n";
    $emailContent .= "Adresse: $adresse\n";
    $emailContent .= "Ville: $ville\n";
    $emailContent .= "Code postal: $code_postal\n\n";
    
    $emailContent .= "EXPÉRIENCE & MOTIVATION\n";
    $emailContent .= "-".str_repeat("-", 30)."\n";
    $emailContent .= "Formation souhaitée: $formation\n";
    $emailContent .= "Expérience: $experience\n";
    $emailContent .= "Book/Portfolio: $book\n";
    $emailContent .= "Motivation:\n$motivation\n\n";
    $emailContent .= "Objectifs:\n$objectifs\n\n";
    
    $emailContent .= "MENSURATIONS\n";
    $emailContent .= "-".str_repeat("-", 30)."\n";
    $emailContent .= "Taille: $taille cm\n";
    $emailContent .= "Poids: $poids kg\n";
    $emailContent .= "Tour de poitrine: $tour_poitrine cm\n";
    $emailContent .= "Tour de taille: $tour_taille cm\n";
    $emailContent .= "Tour de hanches: $tour_hanches cm\n";
    $emailContent .= "Pointure: $pointure\n";
    $emailContent .= "Couleur des yeux: $couleur_yeux\n";
    $emailContent .= "Couleur des cheveux: $couleur_cheveux\n";
    $emailContent .= "Particularités: $particularites\n\n";
    
    $emailContent .= "=".str_repeat("=", 60)."\n";
    $emailContent .= "Date d'inscription: ".date('Y-m-d H:i:s')."\n";
    
    // En-têtes email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "From: " . $smtp_config['from_email'] . "\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    $subject = "Nouvelle inscription - $prenom $nom";
    
    // IMPORTANT: Configuration SMTP requise
    if (empty($smtp_config['host']) || 
        empty($smtp_config['username']) || 
        empty($smtp_config['password']) ||
        empty($smtp_config['from_email']) ||
        empty($smtp_config['to_email'])) {
        
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'message' => 'La configuration SMTP n\'est pas complète. Veuillez remplir les paramètres SMTP dans send-inscription.php (host, port, username, password, from_email, to_email)'
        ]);
        exit;
    }
    
    // Utiliser PHPMailer ou mail() simple - selon votre configuration
    // Pour une solution simple, utilisez mail()
    if (mail($smtp_config['to_email'], $subject, $emailContent, $headers)) {
        http_response_code(200);
        echo json_encode([
            'success' => true, 
            'message' => 'Inscription reçue avec succès! Nous vous contacterons bientôt.'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'message' => 'Erreur lors de l\'envoi du formulaire. Veuillez réessayer.'
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
