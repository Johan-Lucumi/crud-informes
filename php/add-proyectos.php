<?php
require_once("conex.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = strtoupper(trim($_POST["nombre_proyecto"]));
    $descripcion = ucfirst(trim($_POST["descripcion_proyecto"]));

    $stmt = $con->prepare("INSERT INTO Proyecto (nombre, descripcion) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $descripcion);

    if ($stmt->execute()) {
        header("Location: proyectos.php?exito=1");
        exit();
    } else {
        header("Location: proyectos.php?exito=0");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Añadir Proyecto</title>
    <link rel="stylesheet" href="../style/tablas.css" />
    <link rel="stylesheet" href="../style/formulario.css" />
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
</head>
<body>
    <header class="header-nav">
        <div class="left-section">
            <div class="logo-container">
                <img src="../assets/logo.png" alt="Logo" class="logo" />
                <span class="logo-texto">Gestion escolar</span>
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
        <div class="right-section"></div>
    </header>

    <div class="content form-content">
        <h1 class="titulo">Añadir Proyecto</h1>

        <div class="form-container">
            <form action="" method="POST" class="styled-form">
                <div class="form-group">
                    <label for="nombre_proyecto">Nombre del Proyecto:</label>
                    <input type="text" id="nombre_proyecto" name="nombre_proyecto" required>
                </div>

                <div class="form-group">
                    <label for="descripcion_proyecto">Descripción:</label>
                    <textarea id="descripcion_proyecto" name="descripcion_proyecto" rows="5" required></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button submit-button">REGISTRAR PROYECTO</button>
                    <button type="button" class="button cancel-button" onclick="window.history.back();">CANCELAR</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
