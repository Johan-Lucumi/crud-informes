<?php
require_once("conex.php");

$id_docente = $_GET['id'] ?? null; 

if (!$id_docente) {
    header("Location: docentes.php");
    exit();
}

$docente_actual = [
    'nombre' => '',
    'apellido' => '',
    'correo' => '',
    'telefono' => '',
    'area' => ''
]; 

$sql_select = "SELECT nombre, apellido, correo, telefono, area FROM Docente WHERE id_docente = ?";
if ($stmt_select = $con->prepare($sql_select)) {
    $stmt_select->bind_param("i", $id_docente);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    if ($result_select->num_rows > 0) {
        $docente_actual = $result_select->fetch_assoc();
    } else {
        header("Location: docentes.php?error=no_docente_encontrado");
        exit();
    }
    $stmt_select->close();
} else {
    echo "Error en la preparación de la consulta de selección: " . $con->error;

}


// --- 2. Procesar el formulario cuando se envía (edición) ---
if (isset($_POST['editar'])) {
    $nombre_nuevo = strtoupper($_POST['nombre']);
    $apellido_nuevo = strtoupper($_POST['apellido']);
    $correo_nuevo = $_POST['correo'];
    $telefono_nuevo = $_POST['telefono'];
    $area_nuevo = strtoupper($_POST['area']);

    $update = "UPDATE Docente SET nombre=?, apellido=?, correo=?, telefono=?, area=? WHERE id_docente=?";
    $stmt_update = $con->prepare($update);
    // Asegúrate de que los tipos en bind_param coincidan con tu DB (s=string, i=int)
    $stmt_update->bind_param("sssssi", $nombre_nuevo, $apellido_nuevo, $correo_nuevo, $telefono_nuevo, $area_nuevo, $id_docente);
    $rta = $stmt_update->execute();
    $stmt_update->close();

    if ($rta) {
        header("Location: docentes.php?editado=1");
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
    <title>Editar Docente</title>
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
    <h1 class="titulo">Editar Docente</h1>

    <div class="form-container">
        <form action="" method="POST" class="styled-form">
            <div class="form-group">
                <label for="nombre">Nombre del Docente:</label>
                <input type="text" id="nombre" name="nombre" required 
                       value="<?php echo htmlspecialchars($docente_actual['nombre']); ?>" />
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required 
                       value="<?php echo htmlspecialchars($docente_actual['apellido']); ?>" />
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" required 
                       value="<?php echo htmlspecialchars($docente_actual['correo']); ?>" />
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required 
                       value="<?php echo htmlspecialchars($docente_actual['telefono']); ?>" />
            </div>

            <div class="form-group">
                <label for="area">Área:</label>
                <input type="text" id="area" name="area" required 
                       value="<?php echo htmlspecialchars($docente_actual['area']); ?>" />
            </div>

            <div class="form-actions">
                <button type="submit" name="editar" class="button submit-button">Guardar Cambios</button>
                <button type="button" class="button cancel-button" onclick="window.location.href='docentes.php';">Cancelar</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>