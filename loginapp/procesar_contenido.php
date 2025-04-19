<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
require 'db.php';

// Recoger datos
$titulo      = $_POST['titulo'];
$autor       = $_POST['autor'];
$precio      = $_POST['precio'];
$formato     = $_POST['formato'];
$descripcion = $_POST['descripcion'];

// Procesar archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    die("Error al subir el archivo.");
}

$uploadsDir = __DIR__ . '/uploads/';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$tmpName  = $_FILES['archivo']['tmp_name'];
$origName = basename($_FILES['archivo']['name']);
$target   = $uploadsDir . uniqid() . "_" . $origName;

if (!move_uploaded_file($tmpName, $target)) {
    die("No se pudo mover el archivo subido.");
}

// Guardar metadata en BD
$stmt = $conn->prepare("
    INSERT INTO contenidos
      (titulo, descripcion, tipo, url, precio, id_usuario)
    VALUES
      (:titulo, :descripcion, :tipo, :url, :precio, :id_usuario)
");

$stmt->execute([
    'titulo'      => $titulo,
    'descripcion' => $descripcion,
    'tipo'        => $formato,
    'url'         => $target,
    'precio'      => $precio,
    'id_usuario'  => $_SESSION['admin_id'] ?? 1 // por defecto puedes dejar 1 si es un admin fijo
]);

echo "Contenido subido con éxito. <a href='vista_admin.php'>Volver al panel</a>";
?>
