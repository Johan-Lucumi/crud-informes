<?php
require_once("conex.php");

if (isset($_POST['registro'])) {
    // Tomar los datos desde el formulario
    $nombre = strtoupper($_POST['nombre_estudiante']);
    $apellido = strtoupper($_POST['apellido_estudiante']);
    $grado = $_POST['grado_estudiante'];

    // Consulta segura con prepared statement
    $sql = "INSERT INTO Estudiante (nombre, apellido, grado) VALUES (?, ?, ?)";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("sss", $nombre, $apellido, $grado);
        $rta = $stmt->execute();
        $stmt->close();

        if ($rta) {
            header("Location: estudiantes.php?exito=1");
            exit();
        } else {
            echo "Error al insertar estudiante.";
        }
    } else {
        echo "Error en la preparación de la consulta: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Añadir Estudiante</title>
    <link rel="stylesheet" href="../style/tablas.css" />
    <link rel="stylesheet" href="../style/formulario.css" />
    <link rel="icon" href="../assets/logo.png" type="image/x-icon" />
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
    </header>

    <div class="content form-content">
        <h1 class="titulo">Añadir Estudiante</h1>

        <div class="form-container">
            <form action="" method="POST" class="styled-form">

                <div class="form-group">
                    <label for="nombre_estudiante">Nombre del Estudiante:</label>
                    <input type="text" id="nombre_estudiante" name="nombre_estudiante" required>
                </div>

                <div class="form-group">
                    <label for="apellido_estudiante">Apellido:</label>
                    <input type="text" id="apellido_estudiante" name="apellido_estudiante" required>
                </div>

                <div class="form-group">
                    <label for="grado_estudiante">Grado del Estudiante:</label>
                    <select id="grado_estudiante" name="grado_estudiante" required>
                        <option value="">Seleccione un grado</option>
                        <option value="10">Décimo</option>
                        <option value="11">Undécimo</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" name="registro" class="button submit-button">REGISTRAR ESTUDIANTE</button>
                    <button type="button" class="button cancel-button" onclick="window.history.back();">CANCELAR</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
