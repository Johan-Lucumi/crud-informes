<?php
require_once("conex.php");

if (isset($_POST['registro'])) {
    // Tomar los datos del formulario y convertir nombre y apellido a mayúsculas
    $nombre = strtoupper($_POST['nombre_docente']);
    $apellido = strtoupper($_POST['apellido_docente']);
    $correo = $_POST['correo_docente'];
    $telefono = $_POST['telefono_docente'];
    $area = $_POST['area_docente'];

    // Consulta segura con prepared statement
    $sql = "INSERT INTO Docente (nombre, apellido, correo, telefono, area) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("sssss", $nombre, $apellido, $correo, $telefono, $area);
        $rta = $stmt->execute();
        $stmt->close();

        if ($rta) {
            header("Location: docentes.php?exito=1");
            exit();
        } else {
            echo "Error al insertar docente.";
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
  <title>Añadir Docente</title>
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
        <div class="button-logo proyectos"></div>
        <a class="button" href="proyectos.php">PROYECTOS</a>
      </div>
      <div class="button-group">
        <div class="button-logo estudiantes"></div>
        <a class="button" href="estudiantes.php">ESTUDIANTES</a>
      </div>
    </div>
  </header>

  <div class="content form-content">
    <h1 class="titulo">Añadir Docente</h1>

    <div class="form-container">
      <form action="" method="POST" class="styled-form">

        <div class="form-group">
          <label for="nombre_docente">Nombre:</label>
          <input type="text" id="nombre_docente" name="nombre_docente" required />
        </div>

        <div class="form-group">
          <label for="apellido_docente">Apellido:</label>
          <input type="text" id="apellido_docente" name="apellido_docente" required />
        </div>

        <div class="form-group">
          <label for="correo_docente">Correo:</label>
          <input type="email" id="correo_docente" name="correo_docente" required />
        </div>

        <div class="form-group">
            <label for="telefono_docente">Telefono del Docente</label>
            <input type="text" id="telefono_docente" name="telefono_docente" required>
        </div>

        <div class="form-group">
          <label for="area_docente">Área:</label>
          <input type="text" id="area_docente" name="area_docente" required />
        </div>

        <div class="form-actions">
          <button type="submit" name="registro" class="button submit-button">REGISTRAR DOCENTE</button>
          <button type="button" class="button cancel-button" onclick="window.history.back();">CANCELAR</button>
        </div>

      </form>
    </div>
  </div>
</body>
</html>

