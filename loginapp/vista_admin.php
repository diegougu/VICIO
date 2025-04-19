<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
</head>
<body>
    <h1>Bienvenido Administrador</h1>

    <p>Selecciona una opción:</p>

    <form action="agregar_contenido.php" method="get" style="display:inline;">
        <button type="submit">Agregar Contenido</button>
    </form>

    <form action="editar_categorias.php" method="get" style="display:inline;">
        <button type="submit">Editar Categoría</button>
    </form>
</body>
</html>
