<?php
$host = "localhost";
$dbname = "viciobd"; // <- ESTE debe coincidir con el nombre de tu base en pgAdmin
$user = "postgres";
$password = "diego";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // echo "Conectado correctamente a viciobd";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>
