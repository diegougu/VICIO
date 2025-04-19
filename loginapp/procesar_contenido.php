<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
require 'db.php';

// Recoger datos del formulario
$titulo      = $_POST['titulo'];
$autor       = $_POST['autor'];
$precio      = $_POST['precio'];
$categoria   = $_POST['categoria'];
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

// Insertar en la base de datos
$stmt = $conn->prepare("
    INSERT INTO contenidos
      (titulo, descripcion, tipo, url, precio, id_usuario, id_categoria)
    VALUES
      (:titulo, :descripcion, :tipo, :url, :precio, :id_usuario, :id_categoria)
");

$stmt->execute([
    'titulo'       => $titulo,
    'descripcion'  => $descripcion,
    'tipo'         => $formato,
    'url'          => $target,
    'precio'       => $precio,
    'id_usuario'   => $_SESSION['admin_id'] ?? 0,
    'id_categoria' => $categoria
]);

echo "Contenido subido con éxito. <a href='vista_admin.php'>Volver al panel</a>";
