<?php

require_once("conex.php"); // Asegúrate de que esta ruta es correcta

/*Recojo estudiantes de la tabla */
$estudiantes = [];
$sql_estudiantes = "SELECT id_estudiante, nombre, apellido FROM Estudiante ORDER BY nombre ASC";
$res_estudiantes = $con->query($sql_estudiantes);
if ($res_estudiantes && $res_estudiantes->num_rows > 0) {
    while ($row = $res_estudiantes->fetch_assoc()) {
        $estudiantes[] = $row;
    }
}

/*Recojo proyectos de la tabla */
$proyectos = [];
$sql_proyectos = "SELECT id_proyecto, nombre FROM Proyecto ORDER BY nombre ASC";
$res_proyectos = $con->query($sql_proyectos);
if ($res_proyectos && $res_proyectos->num_rows > 0) {
    while ($row = $res_proyectos->fetch_assoc()) {
        $proyectos[] = $row;
    }
}

/*Recojo docentes de la tabla */
$docentes = [];
$sql_docentes = "SELECT id_docente, nombre, apellido FROM Docente ORDER BY nombre ASC";
$res_docentes = $con->query($sql_docentes);
if ($res_docentes && $res_docentes->num_rows > 0) {
    while ($row = $res_docentes->fetch_assoc()) {
        $docentes[] = $row;
    }
}

// Envio los datos del formulario
if (isset($_POST['registro'])) {

    $fecha_actividad = $_POST['fecha_actividad'];
    $estudiante_id = $_POST['estudiante_actividad'];
    $proyecto_id = $_POST['proyecto_actividad'];
    $docente_id = $_POST['docente_encargado'];
    $cantidad_horas = $_POST['Cantidad_horas'];
    $trabajo_realizado = $_POST['trabajo_realizado'];

    //se validan los datos y se limpian
    $fecha_actividad = htmlspecialchars($fecha_actividad);
    $estudiante_id = (int)$estudiante_id;
    $proyecto_id = (int)$proyecto_id;
    $docente_id = (int)$docente_id;
    $cantidad_horas = (int)$cantidad_horas;
    $trabajo_realizado = htmlspecialchars($trabajo_realizado);

    // Hacemos la consulta para insertar el informe
    // *** CAMBIO AQUÍ: Añadimos 'horas_acumuladas' a las columnas y a los VALUES (?)
    $sql_insert = "INSERT INTO Informe (fecha, cantidad_horas, trabajo_realizado, Estudiante_id_estudiante, Proyecto_id_proyecto, Docente_id_docente, horas_acumuladas) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Consulta segura con prepared statement
    if ($stmt = $con->prepare($sql_insert)) {
        // *** CAMBIO AQUÍ: La cadena de tipos ahora tiene 7 caracteres ('s' para fecha, 'i' para cantidad_horas, 's' para trabajo_realizado, 'i' para los 3 IDs, 'i' para horas_acumuladas)
        // Y añadimos $cantidad_horas como el valor para 'horas_acumuladas'
        $stmt->bind_param("sisiiii", $fecha_actividad, $cantidad_horas, $trabajo_realizado, $estudiante_id, $proyecto_id, $docente_id, $cantidad_horas); // LÍNEA 53 (ahora el número de 'i' ha aumentado)
        $rta = $stmt->execute(); // LÍNEA 54 (si no cambiaste nada)

        if ($rta) {
            header("Location: informes.php?exito=1");
            exit(); // Es importante salir después de la redirección
        } else {
            // Si la inserción falló, muestra el error específico de la DB
            echo "Error al insertar informe: " . $stmt->error; // LÍNEA 63
        }
        $stmt->close(); // Cierra la sentencia aquí
    } else {
        // Error si la preparación de la consulta falla
        echo "Error en la preparación de la consulta: " . $con->error;
    }
}
// Cierra la conexión al final del script si no hay más operaciones de BD
if ($con) {
    $con->close();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Añadir Nuevo Informe</title>
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
        <h1 class="titulo">Agregar informe de Labor Social</h1>

        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="styled-form">
                <div class="form-group">
                    <label for="fecha_actividad">Fecha de la actividad:</label>
                    <input type="date" id="fecha_actividad" name="fecha_actividad" required>
                </div>

                <div class="form-group">
                    <label for="estudiante_actividad">Estudiante:</label>
                    <select id="estudiante_actividad" name="estudiante_actividad" required>
                        <option value="">Seleccione un Estudiante</option>
                        <?php foreach ($estudiantes as $estudiante): ?>
                            <option value="<?php echo htmlspecialchars($estudiante['id_estudiante']); ?>">
                                <?php echo htmlspecialchars($estudiante['nombre'] . " " . $estudiante['apellido']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="proyecto_actividad">Proyecto:</label>
                    <select id="proyecto_actividad" name="proyecto_actividad" required>
                        <option value="">Seleccione un Proyecto</option>
                        <?php foreach ($proyectos as $proyecto): ?>
                            <option value="<?php echo htmlspecialchars($proyecto['id_proyecto']); ?>">
                                <?php echo htmlspecialchars($proyecto['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="docente_encargado">Docente encargado:</label>
                    <select id="docente_encargado" name="docente_encargado" required>
                        <option value="">Seleccione un Docente</option>
                        <?php foreach ($docentes as $docente): ?>
                            <option value="<?php echo htmlspecialchars($docente['id_docente']); ?>">
                                <?php echo htmlspecialchars($docente['nombre'] . " " . $docente['apellido']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Cantidad_horas">Cantidad de horas:</label>
                    <input type="number" id="Cantidad_horas" name="Cantidad_horas" required min="1">
                </div>

                <div class="form-group">
                    <label for="trabajo_realizado">Descripción del trabajo realizado:</label>
                    <textarea id="trabajo_realizado" name="trabajo_realizado" rows="3" required></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" name="registro" class="button submit-button">GUARDAR INFORME</button>
                    <button type="button" class="button cancel-button" onclick="window.history.back();">CANCELAR</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>