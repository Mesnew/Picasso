<?php
$servername = "localhost";
$username = "Picasso";
$password = "LyQohx0SGmcQJgLnx2F0";
$dbname = "Picasso";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
