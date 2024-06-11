<?php global $conn;
include 'db.config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/index">Exposition Picasso</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="/Oeuvres">Les œuvres</a></li>
            <li class="nav-item"><a class="nav-link" href="/Infos">Informations pratiques</a></li>
            <li class="nav-item"><a class="nav-link" href="/Base">Tarifs</a></li>
            <li class="nav-item"><a class="nav-link" href="/Mentions">Mentions Légales</a></li>
            <li class="nav-item"><a class="nav-link" href="/Formulaire">Formulaire</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin">Administration</a></li>
        </ul>
    </div>
</nav>

<div class="container content-wrapper">
    <h2>Administration</h2>
    <form action="admin.php" method="post">
        <div class="form-group">
            <label for="visitor_limit">Nombre maximum de visiteurs par jour :</label>
            <input type="number" id="visitor_limit" name="visitor_limit" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $visitor_limit = intval($_POST['visitor_limit']);
        $sql = "UPDATE settings SET limit_visitors=$visitor_limit WHERE setting='visitor_limit'";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success mt-3'>Limite mise à jour avec succès.</div>";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    }

    // Récupérer la limite actuelle
    $sql = "SELECT limit_visitors FROM settings WHERE setting='visitor_limit'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_limit = $row['limit_visitors'];
    ?>

    <p>Limite actuelle : <?php echo $current_limit; ?> visiteurs par jour.</p>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
