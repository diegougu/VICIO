<?php
require 'db.php';

$admins = [
    ['nombre' => 'admin1', 'correo' => 'admin1@admin.com', 'password' => 'a1'],
    ['nombre' => 'admin2', 'correo' => 'admin2@admin.com', 'password' => 'a2'],
    ['nombre' => 'admin3', 'correo' => 'admin3@admin.com', 'password' => 'a3'],
    ['nombre' => 'admin4', 'correo' => 'admin4@admin.com', 'password' => 'a4'],
    ['nombre' => 'admin5', 'correo' => 'admin5@admin.com', 'password' => 'a5'],
];

foreach ($admins as $admin) {
    $hashed = password_hash($admin['password'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO administradores (nombre, correo, contraseña) VALUES (:nombre, :correo, :contrasena)");
    $stmt->execute([
        'nombre' => $admin['nombre'],
        'correo' => $admin['correo'],
        'contrasena' => $hashed
    ]);
}

echo "Administradores insertados correctamente.";
?>
