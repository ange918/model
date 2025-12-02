# MODELS ACADEMY MANAGEMENT

Site web moderne et professionnel pour une agence de mannequins spécialisée dans la formation.

## Description du Projet

Site web complet développé en HTML, CSS et JavaScript vanilla pour MODELS ACADEMY MANAGEMENT. Le site présente une agence de formation de mannequins avec trois spécialités :
- Formation Mannequin Podium
- Formation Model Photo
- Formation Développement Personnel

## Structure du Site

### Pages Principales

1. **index.html** - Page d'accueil
   - Section hero plein écran
   - Section À propos avec photo et texte en 2 colonnes
   - Statistiques animées (mannequins formés, défilés, projets photos, années d'expérience)
   - Aperçu des 3 formations
   - FAQ interactive avec accordéon
   - Section Blog avec 3 articles
   - Call-to-action pour l'inscription

2. **about.html** - À propos
   - Histoire et objectifs de l'agence
   - Valeurs de l'entreprise (4 piliers)
   - Vidéo de présentation (YouTube embed)
   - Galerie de 12 images responsive
   - Équipe de 2 personnes avec liens sociaux
   - Section blog avec 3 articles

3. **formations.html** - Formations
   - Détails complets des 3 formations :
     * Mannequin Podium (2 500 €, 4 mois)
     * Model Photo (2 000 €, 3 mois)
     * Développement Personnel (3 500 €, 6 mois)
   - Pour chaque formation : objectifs, programme, durée, conditions, prix

4. **mannequins.html** - Nos mannequins
   - Liste de 26 mannequins (12 femmes, 14 hommes)
   - Onglets de filtrage (TOUT / FEMME / HOMME)
   - Bouton retour
   - Navigation vers les profils individuels

5. **model-detail.html** - Profil mannequin dynamique
   - Données complètes pour 6 mannequins (Emma, Sophie, Léa, Clara, Marie, Julie)
   - Navigation par paramètre URL (?id=1-6)
   - Mensurations détaillées
   - Polaroids et portfolio
   - Expérience professionnelle

6. **inscription.html** - Formulaire d'inscription
   - Processus en 4 étapes :
     * Étape 1 : Informations personnelles
     * Étape 2 : Expérience et motivation
     * Étape 3 : Mensurations
     * Étape 4 : Upload de photos et validation
   - Navigation fluide entre les étapes
   - Validation des champs obligatoires

7. **contact.html** - Contact
   - Formulaire de contact
   - Coordonnées complètes (téléphone, email, WhatsApp, Instagram)
   - Localisation Google Maps
   - Horaires d'ouverture

### Fichiers CSS

- **styles.css** - Styles globaux
  - Header et footer constants
  - Design responsive mobile-first
  - Animations et transitions
  - Variables CSS pour la palette de couleurs
  - Media queries pour tous les écrans

- **inscription.css** - Styles du formulaire d'inscription
  - Barre de progression des étapes
  - Grille de formulaire responsive
  - Zones d'upload d'images
  - Animations des transitions

### Fichiers JavaScript

- **main.js** - Fonctionnalités globales
  - Menu mobile (hamburger)
  - Compteurs animés avec Intersection Observer
  - Accordéon FAQ
  - Marquage du lien actif dans la navigation
  - Effet de scroll sur le header

- **inscription.js** - Formulaire multi-étapes
  - Navigation entre les 4 étapes
  - Validation des champs obligatoires
  - Prévisualisation des images uploadées
  - Soumission du formulaire

- **model-detail.html (inline JS)** - Profils dynamiques
  - Base de données des 6 mannequins
  - Chargement dynamique via URL parameters
  - Mise à jour du DOM avec les données du mannequin

### Serveur

- **server.py** - Serveur HTTP Python
  - Port 5000 avec binding 0.0.0.0
  - Headers de cache désactivés
  - Réutilisation d'adresse (allow_reuse_address)
  - Redirection automatique / vers /index.html

## Technologies Utilisées

- **HTML5** - Structure sémantique
- **CSS3** - Flexbox, Grid, animations, media queries
- **JavaScript ES6+** - Vanilla JS sans frameworks
- **Boxicons** - Bibliothèque d'icônes (CDN)
- **Google Fonts** - Police Poppins
- **Python 3.11** - Serveur HTTP simple

## Design

Le site utilise une palette de couleurs minimaliste **blanc et noir** pour un look professionnel et élégant :
- **Fond** : Blanc (#ffffff) pour la pureté et la clarté
- **Texte principal** : Noir (#000000) pour la lisibilité
- **Texte secondaire** : Gris (#666666, #999999) pour la hiérarchie visuelle
- **Boutons CTA** : Noir avec texte blanc pour un contraste fort
- **Bordures** : Gris clair (#e5e5e5) pour les séparations subtiles

### Pages Mannequins (Design Spécifique)

**mannequins.html** - Liste des mannequins
- Grille 2 colonnes responsive
- Grandes photos professionnelles (500px de hauteur)
- Nom du mannequin en titre élégant
- Spécialité en texte gris
- Bouton noir "EN SAVOIR PLUS" avec icône plus

**model-detail.html** - Profil individuel
- Layout en deux colonnes : photo (400px) à gauche, informations à droite
- Section "À propos" avec icônes et grille d'informations (Taille, Cheveux, Yeux, Ville, Expérience)
- Section "Mensurations" avec 4 boîtes (Buste, Taille, Hanches, Pointure)
- Section "Galeries" avec 3 onglets interactifs :
  - Portfolio : Photos principales du mannequin
  - Fashion Show : Photos de défilés
  - Shooting : Photos de séances photo
- Grille de photos responsive (3 colonnes sur desktop, 1 sur mobile)

## Fonctionnalités

### Design & UX
- Design moderne inspiré du style Fash Link
- Palette de couleurs élégante (noir, or, blanc)
- Responsive mobile-first
- Animations légères et transitions fluides
- Navigation intuitive

### Interactivité
- Compteurs animés déclenchés au scroll
- FAQ avec accordéon
- Menu mobile hamburger
- Formulaire multi-étapes avec validation
- Navigation dynamique entre profils de mannequins
- Prévisualisation d'images

### Optimisations
- Cache désactivé pour le développement
- Images optimisées depuis Unsplash
- Code modulaire et maintenable
- Variables CSS pour faciliter la personnalisation
- **Lazy Loading** : Toutes les images utilisent `loading="lazy"` pour un chargement différé (améliore significativement les performances)
- Les logos utilisent `loading="eager"` pour un chargement immédiat

### Utilisation d'Images Google Drive

Pour utiliser des images stockées sur Google Drive :
1. Partagez l'image en mode "Tout le monde avec le lien peut voir"
2. Copiez l'ID du fichier depuis le lien (exemple: `https://drive.google.com/file/d/ID_ICI/view`)
3. Utilisez ce format dans vos balises img :
```html
<img src="https://drive.google.com/uc?export=view&id=VOTRE_ID_ICI" alt="Description" loading="lazy">
```

## Lancement du Projet

Le serveur HTTP démarre automatiquement via le workflow "Start Web Server" :
```bash
python3 server.py
```

Le site est accessible sur : http://0.0.0.0:5000/

## Structure des Fichiers

```
/
├── index.html              # Page d'accueil
├── about.html             # À propos
├── formations.html        # Formations
├── mannequins.html        # Liste mannequins
├── model-detail.html      # Profil mannequin (dynamique)
├── inscription.html       # Formulaire 4 étapes
├── contact.html           # Contact
├── styles.css             # CSS global
├── inscription.css        # CSS formulaire
├── main.js               # JavaScript global
├── inscription.js        # JavaScript formulaire
├── server.py             # Serveur HTTP
└── replit.md             # Documentation
```

## Ajout de Nouveaux Mannequins

Pour ajouter un nouveau mannequin :

1. Dans **mannequins.html**, ajouter une nouvelle carte :
```html
<div class="model-card" onclick="window.location.href='model-detail.html?id=7'">
    <!-- Contenu de la carte -->
</div>
```

2. Dans **model-detail.html**, ajouter les données dans l'objet `models` :
```javascript
'7': {
    name: 'Nouveau Nom',
    specialty: 'Podium/Photo/Mixte',
    photo: 'url_image',
    height: '1m75',
    // ... autres données
}
```

## Personnalisation

Les couleurs principales sont définies dans `styles.css` via des variables CSS :
```css
:root {
    --primary-color: #000000;    /* Noir */
    --accent-color: #d4af37;     /* Or */
    --secondary-color: #f5f5f5;  /* Gris clair */
}
```

## Date de Création

Novembre 2024

## Mises à Jour Récentes (Décembre 2025)

### Nouvelle Structure d'Images (src/images/)
- Tous les 26 mannequins utilisent maintenant le format `src/images/[nom]/` avec :
  - `portrait.jpg` - Photo principale
  - `portfolio-1.jpg` à `portfolio-6.jpg` - 6 photos portfolio
  - `fashion-1.jpg` à `fashion-6.jpg` - 6 photos défilés
  - `shooting-1.jpg` à `shooting-6.jpg` - 6 photos shootings

### Pages Blog
- 3 articles de blog complets créés :
  - `blog-article-1.html` - Les Tendances du Mannequinat en 2024
  - `blog-article-2.html` - Comment Réussir Son Premier Défilé
  - `blog-article-3.html` - La Préparation du Book Photo Parfait
- Liens mis à jour dans index.html et about.html

## Mises à Jour Précédentes (Novembre 2025)

### Améliorations UI/UX
- **Hero Section Assombrie** : Overlay à 0.65 pour meilleure lisibilité du texte
- **Transitions Fluides** : Animations fadeIn sur le body et les images avec Intersection Observer
- **Gestion Manuelle des Images** : Système configurable pour portfolio/fashion/shooting photos

### Configuration des Images avec IBB.CO

Le fichier `models-data.js` centralise toutes les donnees des mannequins et leurs images.

**Comment utiliser les liens ibb.co :**

1. Uploadez votre image sur https://imgbb.com/
2. Apres l'upload, cliquez sur "Get codes" 
3. Copiez le "Direct link" (lien direct), PAS le lien de la page
   - Lien page (NE PAS UTILISER): `https://ibb.co/dwr9LTNc`
   - Lien direct (A UTILISER): `https://i.ibb.co/xxxxx/nom-image.jpg`
4. Collez ce lien dans `models-data.js`

**Exemple dans models-data.js :**
```javascript
'1': {
    name: 'TOUNDOH OLERIE',
    photo: 'https://i.ibb.co/Jw2LMRG/portrait.jpg',  // Lien direct ibb.co
    portfolioPhotos: [
        'https://i.ibb.co/xxxxx/portfolio-1.jpg',
        'https://i.ibb.co/xxxxx/portfolio-2.jpg',
        'img/local-image.jpg'  // Ou image locale
    ],
    fashionPhotos: [
        'https://i.ibb.co/xxxxx/fashion-1.jpg'
    ],
    shootingPhotos: [
        'https://i.ibb.co/xxxxx/shooting-1.jpg'
    ]
}
```

**Types de liens acceptes :**
- Liens ibb.co directs: `https://i.ibb.co/xxxxx/image.jpg`
- Images locales: `img/nom-image.jpg`
- Autres hebergeurs (Unsplash, etc.)

## Notes Techniques

- Le serveur utilise `allow_reuse_address` pour permettre les redémarrages rapides
- Les images proviennent d'Unsplash (à remplacer par de vraies photos en production)
- Le formulaire d'inscription est actuellement front-end only (ajouter un backend pour le traitement réel)
- La vidéo Instagram peut être remplacée par un vrai embed
