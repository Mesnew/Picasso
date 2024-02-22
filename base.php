<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarifs</title>

  <!-- Liens vers Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <style>


    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #007bff;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }

    /* Style pour le navbar */
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
  </style>
</head>
<body>

<!-- Navbar -->
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

<!-- Contenu de la page -->
<div class="container">
  <h2>Tarifs</h2>

  <!-- Tableau des tarifs -->
  <table>
    <tr>
      <th>Catégories</th>
      <th>Prix</th>
    </tr>
    <tr class="normal">
      <td>Normal</td>
      <td>32€</td>
    </tr>
    <tr class="reduit">
      <td>Tarif réduit (enfants entre 12 et 18, séniors de plus de 65 ans)</td>
      <td>24€</td>
    </tr>
    <tr class="etudiant">
      <td>Tarif étudiant, demandeurs d’emploi</td>
      <td>20€</td>
    </tr>
    <tr class="membre">
      <td>Tarif membre de l’association du festival international d’animation d’Annecy</td>
      <td>12€</td>
    </tr>
    <tr class="moins12">
      <td>Tarif -12 ans</td>
      <td>5€</td>
    </tr>
  </table>
</div>

<!-- Liens vers les scripts Bootstrap -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
