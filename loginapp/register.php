<?php
// Mostrar errores para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
require 'db.php';

// Obtener datos del formulario
$nombre = $_POST['username'];
$correo = $_POST['email'];
$contraseña = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validar contraseñas
if ($contraseña !== $confirm_password) {
    die(" Las contraseñas no coinciden");
}

// Hashear la contraseña
$hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

// Verificar si el usuario o el correo ya existen
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = :nombre OR correo = :correo");
$stmt->execute(['nombre' => $nombre, 'correo' => $correo]);

if ($stmt->rowCount() > 0) {
    die(" El usuario o el correo ya existen");
}

// Insertar el nuevo usuario
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña) VALUES (:nombre, :correo, :pass)");
$stmt->execute([
    'nombre' => $nombre,
    'correo' => $correo,
    'pass' => $hashed_password
]);

echo " Registro exitoso. <a href='login.html'>Iniciar sesión</a>";
?>
