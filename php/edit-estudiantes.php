<?php
require_once("conex.php");

$id_estudiante = $_GET['id'] ?? null; 

if (!$id_estudiante) {
    header("Location: estudiantes.php");
    exit();
}

$estudiante_actual = [
    'nombre' => '',
    'apellido' => '',
    'grado' => ''
]; 

$sql_select = "SELECT nombre, apellido, grado FROM Estudiante WHERE id_estudiante = ?";
if ($stmt_select = $con->prepare($sql_select)) {
    $stmt_select->bind_param("i", $id_estudiante);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    if ($result_select->num_rows > 0) {
        $estudiante_actual = $result_select->fetch_assoc();
    } else {
        header("Location: estudiantes.php?error=no_estudiante_encontrado");
        exit();
    }
    $stmt_select->close();
} else {
    echo "Error en la preparación de la consulta de selección: " . $con->error;
}


if (isset($_POST['editar'])) {
    $nombre_nuevo = strtoupper($_POST['nombre']);
    $apellido_nuevo = strtoupper($_POST['apellido']);
    $grado_nuevo = $_POST['grado'];

    $update = "UPDATE Estudiante SET nombre=?, apellido=?, grado=? WHERE id_estudiante=?";
    $stmt_update = $con->prepare($update);
    $stmt_update->bind_param("sssi", $nombre_nuevo, $apellido_nuevo, $grado_nuevo, $id_estudiante);
    $rta = $stmt_update->execute();
    $stmt_update->close();

    if ($rta) {
        header("Location: estudiantes.php?editado=1");
        exit();
    } else {
        echo "Error al actualizar: " . $con->error;
    }
}

$con->close(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Estudiante</title>
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
    <h1 class="titulo">Editar Estudiante</h1>

    <div class="form-container">
        <form action="" method="POST" class="styled-form">
            <div class="form-group">
                <label for="nombre">Nombre del Estudiante:</label>
                <input type="text" id="nombre" name="nombre" required 
                       value="<?php echo htmlspecialchars($estudiante_actual['nombre']); ?>" />
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required 
                       value="<?php echo htmlspecialchars($estudiante_actual['apellido']); ?>" />
            </div>

            <div class="form-group">
                <label for="grado">Grado del Estudiante:</label>
                <select id="grado" name="grado" required>
                    <option value="">Seleccione un grado</option>
                    <option value="10" <?php echo ($estudiante_actual['grado'] == '10') ? 'selected' : ''; ?>>Décimo</option>
                    <option value="11" <?php echo ($estudiante_actual['grado'] == '11') ? 'selected' : ''; ?>>Undécimo</option>
                    </select>
            </div>

            <div class="form-actions">
                <button type="submit" name="editar" class="button submit-button">Guardar Cambios</button>
                <button type="button" class="button cancel-button" onclick="window.location.href='estudiantes.php';">Cancelar</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>