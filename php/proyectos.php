<?php
require_once("conex.php");

// Consulta todos los proyectos
$sql = "SELECT id_proyecto, nombre, descripcion FROM Proyecto";
$resultado = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../style/tablas.css" />
  <link rel="icon" href="../assets/logo.png" type="image/x-icon">
  <title>Proyectos</title>
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
    <div class="right-section">
        <div class="button-group add">
            <div class="button-logo proyectosV"></div>
            <a class="button" href="add-proyectos.php">AÑADIR PROYECTO</a>
        </div>
    </div>
  </header>

  <div class="content">
    <h1 class="titulo">Proyectos Vigentes</h1>

    <div class="tabla-container">
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($row = $resultado->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['id_proyecto']) ?></td>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['descripcion']) ?></td>
                <td>
                  <a href="edit-proyecto.php?id=<?= $row['id_proyecto'] ?>" class="accion editar">
                    <img class="sub-button" src="../assets/edit.png" alt="Editar">
                  </a>
                  <a href="#" class="accion borrar swal-delete" data-id="<?= $row['id_proyecto'] ?>">
                    <img class="sub-button" src="../assets/delete.png" alt="Borrar">
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">No hay proyectos registrados.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Registro exitoso o fallido -->
  <?php if (isset($_GET['exito'])): ?>
  <script>
    Swal.fire({
      icon: <?= $_GET['exito'] == 1 ? "'success'" : "'error'" ?>,
      title: <?= $_GET['exito'] == 1 ? "'¡Proyecto registrado exitosamente!'" : "'Error al registrar el proyecto'" ?>,
      timer: 2000,
      showConfirmButton: false
    });
  </script>
  <?php endif; ?>

  <!-- Edición exitosa -->
  <?php if (isset($_GET['editado']) && $_GET['editado'] == 1): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Proyecto actualizado exitosamente!',
      timer: 2000,
      showConfirmButton: false
    });
  </script>
  <?php endif; ?>

  <!-- Eliminación -->
  <?php if (isset($_GET['eliminado'])): ?>
  <script>
    Swal.fire({
      icon: <?= $_GET['eliminado'] == 1 ? "'success'" : "'error'" ?>,
      title: <?= $_GET['eliminado'] == 1 ? "'¡Proyecto eliminado exitosamente!'" : "'Error al eliminar el proyecto'" ?>,
      timer: 2000,
      showConfirmButton: false
    });
  </script>
  <?php endif; ?>

  <!-- Confirmación con SweetAlert -->
  <script>
    document.querySelectorAll('.swal-delete').forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        const id = this.getAttribute('data-id');

        Swal.fire({
          title: '¿Estás seguro?',
          text: "Esta acción no se puede deshacer.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'delete-proyecto.php?id=' + id;
          }
        });
      });
    });
  </script>

</body>
</html>
