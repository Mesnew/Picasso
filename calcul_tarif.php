<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Résultat du calcul du tarif</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <style>
    /* Style personnalisé pour le navbar */
    .navbar {
      background-color: #343a40; /* Couleur de fond */
    }

    .navbar-brand {
      color: #fff; /* Couleur du texte */
      font-size: 1.5rem; /* Taille de la police */
      font-weight: bold; /* Gras */
    }

    .navbar-nav .nav-link {
      color: #fff; /* Couleur du texte */
    }

    .navbar-nav .nav-link:hover {
      color: #f8f9fa; /* Couleur du texte au survol */
    }
    body {

    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }
    h2 {
      color: #007bff;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="index.html">Exposition Picasso</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="Les%20Oeuvres.html">Les œuvres</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Informations%20pratiques.html">Informations pratiques</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="base.php">Tarifs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Mentions%20légales.html">Mentions Légales</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Formulaire.html">Formulaire</a>
      </li>
    </ul>
  </div>
</nav>
<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les quantités de tickets pour chaque catégorie
  $normal = isset($_POST['normal']) ? intval($_POST['normal']) : 0;
  $reduit = isset($_POST['reduit']) ? intval($_POST['reduit']) : 0;
  $etudiant = isset($_POST['etudiant']) ? intval($_POST['etudiant']) : 0;
  $membre = isset($_POST['membre']) ? intval($_POST['membre']) : 0;
  $moins12 = isset($_POST['moins12']) ? intval($_POST['moins12']) : 0;

  // Définir les prix des tickets pour chaque catégorie
  $prix_normal = 32;
  $prix_reduit = 24;
  $prix_etudiant = 20;
  $prix_membre = 12;
  $prix_moins12 = 5;

  // Calculer le tarif total
  $tarif_total = ($normal * $prix_normal) + ($reduit * $prix_reduit) + ($etudiant * $prix_etudiant) + ($membre * $prix_membre) + ($moins12 * $prix_moins12);

  // Afficher le tarif total
  echo '<div class="container">';
  echo "<h2>Tarif total : $tarif_total €</h2>";
  echo '</div>';
}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
