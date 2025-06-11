<?php
require_once("conex.php");

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: proyectos.php");
    exit();
}

// Procesar edición al enviar el formulario
if (isset($_POST['editar'])) {
    $nombre_nuevo = trim($_POST['nombre']);
    $descripcion_nuevo = trim($_POST['descripcion']);

    $update = "UPDATE Proyecto SET nombre = ?, descripcion = ? WHERE id_proyecto = ?";
    $stmt_update = $con->prepare($update);
    $stmt_update->bind_param("ssi", $nombre_nuevo, $descripcion_nuevo, $id);
    $rta = $stmt_update->execute();
    $stmt_update->close();

    if ($rta) {
        header("Location: proyectos.php?editado=1");
        exit();
    } else {
        echo "Error al actualizar: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="../style/tablas.css" />
    <link rel="stylesheet" href="../style/formulario.css" />
    <link rel="icon" href="../assets/logo.png" type="image/x-icon" />
</head>
<body>
<header class="header-nav">
    <div class="left-section">
        <div class="logo-container">
            <img src="../assets/logo.png" alt="Logo" class="logo" />
            <span class="logo-texto">Gestión Escolar</span>
        </div>
    </div>
    <div class="main-nav-buttons">
        <div class="button-group">
            <div class="button-logo inicio"></div>
            <a class="button" href="../index.html">INICIO</a>
        </div>
        <div class="button-group">
            <div class="button-logo informes"></div>
            <a class="button" href="informes.php">INFORMES</a>
        </div>
        <div class="button-group">
            <div class="button-logo estudiantes"></div>
            <a class="button" href="estudiantes.php">ESTUDIANTES</a>
        </div>
        <div class="button-group">
            <div class="button-logo profesores"></div>
            <a class="button" href="docentes.php">DOCENTES</a>
        </div>
    </div>
</header>

<div class="content form-content">
    <h1 class="titulo">Editar Proyecto</h1>

    <div class="form-container">
        <form action="" method="POST" class="styled-form">
            <div class="form-group">
                <label for="nombre">Nombre del Proyecto:</label>
                <input type="text" id="nombre" name="nombre" required />
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="editar" class="button submit-button">Guardar Cambios</button>
                <button type="button" class="button cancel-button" onclick="window.location.href='proyectos.php';">Cancelar</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>