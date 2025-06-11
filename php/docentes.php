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
  <title>Docentes</title>
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
    <div class="right-section">
        <div class="button-group add">
            <div class="button-logo profesoresV"></div>
            <a class="button" href="add-docente.php">AÑADIR DOCENTES</a>
        </div>
    </div>
  </header>

  <div class="content">
    <h1 class="titulo">Docentes Activos</h1>

    <div class="tabla-container">
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Área</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT id_docente, nombre, apellido, correo, telefono, area FROM Docente";
          if ($stmt = $con->prepare($query)) {
              $stmt->execute();
              $stmt->bind_result($id, $nombre, $apellido, $correo, $telefono, $area);
              while ($stmt->fetch()) {
                  echo "<tr>
                          <td>" . htmlspecialchars($id) . "</td>
                          <td>" . htmlspecialchars($nombre) . "</td>
                          <td>" . htmlspecialchars($apellido) . "</td>
                          <td>" . htmlspecialchars($correo) . "</td>
                          <td>" . htmlspecialchars($telefono) . "</td>
                          <td>" . htmlspecialchars($area) . "</td>
                          <td>
                            <button class='accion editar' onclick=\"location.href='edit-docente.php?id=$id'\">
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
              echo "<tr><td colspan='7'>❌ Error al consultar docentes</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
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
          window.location.href = 'delete-docente.php?id=' + id;
        }
      });
    }

    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);

      if (urlParams.get('eliminado') === '1') {
        Swal.fire({
          icon: 'success',
          title: '¡Docente eliminado correctamente!',
          showConfirmButton: false,
          timer: 1800
        });
      }

      if (urlParams.get('exito') === '1') {
        Swal.fire({
          icon: 'success',
          title: '¡Docente añadido correctamente!',
          showConfirmButton: false,
          timer: 1800
        });
      }

      if (urlParams.get('editado') === '1') {
        Swal.fire({
          icon: 'success',
          title: '¡Docente actualizado correctamente!',
          showConfirmButton: false,
          timer: 1800
        });
      }

      if (urlParams.has('eliminado') || urlParams.has('exito') || urlParams.has('editado')) {
        window.history.replaceState(null, '', window.location.pathname);
      }
    });
  </script>
</body>
</html>
