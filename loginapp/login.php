<?php
require 'db.php';
session_start();

$username = strtolower(trim($_POST['username']));
$password = $_POST['password'];

// Buscar en administradores por nombre (minúsculas)
$stmt = $conn->prepare("SELECT * FROM administradores WHERE LOWER(nombre) = :nombre");
$stmt->execute(['nombre' => $username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($password, $admin['contraseña'])) {
    $_SESSION['admin'] = $admin['nombre'];
    header("Location: vista_admin.php");
    exit();
}

// Buscar en usuarios por nombre (minúsculas)
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE LOWER(nombre) = :nombre");
$stmt->execute(['nombre' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['contraseña'])) {
    $_SESSION['user'] = $user['nombre'];
    header("Location: vista_usuario.php");
    exit();
}

echo "Nombre de usuario o contraseña incorrectos.";
?>