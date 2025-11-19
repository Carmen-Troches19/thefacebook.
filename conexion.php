<?php
$servername = "localhost";
$username   = "root";
$password   = "mysql";
$dbname     = "thefacebook1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>