<?php

require_once("conex.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../style/tablas.css" />
  <link rel="icon" href="../assets/logo.png" type="image/x-icon">
  <title>Estudiantes</title>
</head>
<body>
  <header class="header-nav">
    <div class="left-section">
        <div class="logo-container">
            <img src="../assets/logo.png" alt="Logo" class="logo" />
            <span class="logo-texto">Gestion Escolar</span>
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
            <div class="button-logo profesores"></div>
            <a class="button" href="docentes.php">DOCENTES</a>
        </div>
    </div>
    <div class="right-section">
        <div class="button-group add">
            <div class="button-logo estudiantesV"></div>
            <a class="button" href="add-estudiantes.php">AÑADIR ESTUDIANTES</a>
        </div>
    </div>
  </header>

  <div class="content">
      <h1 class="titulo">Tabla de Estudiantes</h1>

      <div class="tabla-container">
          <table class="styled-table">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Grado</th>
                  <th>Acciones</th>
              </tr>
              </thead>
              <tbody>
              <?php
                $query = "SELECT id_estudiante, nombre, apellido, grado FROM Estudiante";
                if ($stmt = $con->prepare($query)) {
                    $stmt->execute();
                    $stmt->bind_result($id, $nombre, $apellido, $grado);
                    while ($stmt->fetch()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($id) . "</td>
                                <td>" . htmlspecialchars($nombre) . "</td>
                                <td>" . htmlspecialchars($apellido) . "</td>
                                <td>" . htmlspecialchars($grado) . "</td>
                                <td>
                                  <button class='accion editar' onclick=\"location.href='edit-estudiantes.php?id=$id'\">
                                    <img class='sub-button' src='../assets/edit.png' alt='Editar'>
                                  </button>
                                  <button class='accion borrar' onclick='confirmDelete($id)'>
                                    <img class='sub-button' src='../assets/delete.png' alt='Eliminar'>
                                  </button>
                                </td>
                              </tr>";
                    }
                    $stmt->close();
                } else {
                    echo "<tr><td colspan='5'>❌ Error al consultar estudiantes</td></tr>";
                }
              ?>
              </tbody>
          </table>
      </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Confirmación de eliminación con SweetAlert
  function confirmDelete(id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirigir al script que elimina
        window.location.href = 'delete-estudiantes.php?id=' + id;
      }
    });
  }

  // Mostrar alerta si se eliminó correctamente
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('eliminado') === '1') {
    Swal.fire({
      icon: 'success',
      title: '¡Estudiante eliminado correctamente!',
      showConfirmButton: false,
      timer: 1800
    });
    // Limpiar el parámetro de la URL
    window.history.replaceState({}, document.title, window.location.pathname);
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('exito') === '1') {
      Swal.fire({
        icon: 'success',
        title: '¡Estudiante añadido correctamente!',
        showConfirmButton: false,
        timer: 1800
      });

      // Limpiar ?exito=1 de la URL sin recargar la página
      window.history.replaceState(null, '', window.location.pathname);
    }
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('editado') === '1') {
      Swal.fire({
        icon: 'success',
        title: '¡Estudiante actualizado correctamente!',
        showConfirmButton: false,
        timer: 1800
      });
    }

    if (urlParams.get('exito') === '1') {
      Swal.fire({
        icon: 'success',
        title: '¡Estudiante añadido correctamente!',
        showConfirmButton: false,
        timer: 1800
      });
    }

    if (urlParams.has('editado') || urlParams.has('exito')) {
      window.history.replaceState(null, '', window.location.pathname);
    }
  });
</script>

</body>
</html>
