<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifs</title>
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
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="/index">Exposition Picasso</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/Oeuvres">Les œuvres</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Infos">Informations pratiques</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Base">Tarifs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Mentions">Mentions Légales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Formulaire">Formulaire</a>
            </li>
        </ul>
    </div>
</nav>


<div class="container">
    <h2>Tarifs</h2>
    <table>
        <tr>
            <th>Catégories</th>
            <th>Prix</th>
        </tr>
        <?php
        $servername = "localhost"; // Ajustez selon votre configuration
        $username = "Picasso"; // Votre nom d'utilisateur pour MySQL
        $password = "LyQohx0SGmcQJgLnx2F0"; // Votre mot de passe pour MySQL
        $dbname = "Picasso"; // Le nom de votre base de données

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT categorie, prix FROM tarifs"; // Assurez-vous d'avoir une table qui correspond
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Affichage de chaque ligne de résultat
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["categorie"]. "</td><td>" . $row["prix"] . "€</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Aucun tarif trouvé</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
