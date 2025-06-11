<?php
require_once("conex.php"); // Asegúrate de que esta ruta es correcta

$estudiante_id = null;
$estudiante_info = null;
$informes_del_estudiante = [];
$horas_acumuladas_total = 0;
$proyecto_principal_nombre = "N/A";

// --- Validar y obtener el ID del estudiante de la URL (GET) ---
if (isset($_GET['estudiante_id']) && is_numeric($_GET['estudiante_id'])) {
    $estudiante_id = (int)$_GET['estudiante_id'];
} else {
    // Si no hay ID de estudiante en la URL, redirigir o mostrar un mensaje de error
    header("Location: informes.php?error=no_estudiante_id"); // Redirige a la página de selección
    exit();
}

// Si tenemos un ID de estudiante válido, procedemos a obtener los datos
if ($estudiante_id) {
    // 1. Obtener información del estudiante
    $sql_estudiante_info = "SELECT nombre, apellido, grado FROM Estudiante WHERE id_estudiante = ?";
    if ($stmt_estudiante = $con->prepare($sql_estudiante_info)) {
        $stmt_estudiante->bind_param("i", $estudiante_id);
        $stmt_estudiante->execute();
        $result_estudiante = $stmt_estudiante->get_result();
        if ($result_estudiante->num_rows > 0) {
            $estudiante_info = $result_estudiante->fetch_assoc();
        }
        $stmt_estudiante->close();
    }

    // 2. Obtener los informes detallados para ese estudiante
    $sql_informes = "
        SELECT 
            I.fecha, 
            I.cantidad_horas, 
            I.trabajo_realizado,
            P.nombre AS nombre_proyecto,
            D.nombre AS nombre_docente,
            D.apellido AS apellido_docente
        FROM Informe AS I
        JOIN Estudiante AS E ON I.Estudiante_id_estudiante = E.id_estudiante
        JOIN Proyecto AS P ON I.Proyecto_id_proyecto = P.id_proyecto
        JOIN Docente AS D ON I.Docente_id_docente = D.id_docente
        WHERE I.Estudiante_id_estudiante = ?
        ORDER BY I.fecha ASC;
    ";
    if ($stmt_informes = $con->prepare($sql_informes)) {
        $stmt_informes->bind_param("i", $estudiante_id);
        $stmt_informes->execute();
        $result_informes = $stmt_informes->get_result();
        if ($result_informes->num_rows > 0) {
            while ($row = $result_informes->fetch_assoc()) {
                $informes_del_estudiante[] = $row;
                $horas_acumuladas_total += $row['cantidad_horas']; // Sumar horas para el total
            }
        }
        $stmt_informes->close();
    }

    // Opcional: Obtener el nombre del proyecto principal si hay informes
    if (!empty($informes_del_estudiante)) {
        $proyecto_principal_nombre = $informes_del_estudiante[0]['nombre_proyecto'];
    }
}

// Cerrar la conexión a la base de datos
$con->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro de Actividades Labor Social</title>
    <link rel="stylesheet" href="../style/tablas.css" />
    <link rel="stylesheet" href="../style/informe.css" />
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

    <div class="content">
        <h1 class="titulo">Informe de Labor Social</h1>

        <?php if ($estudiante_info): // Solo mostrar la tabla si se encontró la información del estudiante ?>
            <div class="registro-container">
                <table class="registro-table">
                    <thead>
                        <tr>
                            <th rowspan="2" class="header-logo-cell">
                                <img src="../assets/logo-original.png" alt="Logo Colegio" class="table-logo-img" />
                            </th>
                            <th colspan="4" class="header-title-cell">
                                INSTITUCIÓN EDUCATIVA "XYZ"<br />
                                REGISTRO DETALLADO DE ACTIVIDADES<br />
                                LABOR SOCIAL
                            </th>
                            <th rowspan="2" class="header-flag-cell">
                                <img src="../assets/bandera-xyz.png" alt="Bandera Colegio" class="table-flag-img" />
                            </th>
                        </tr>
                        <tr></tr>
                    </thead>
                    <tbody>
                        <tr class="info-row">
                            <td class="label-cell">Nombre del Estudiante</td>
                            <td colspan="3" class="data-cell">
                                <?php echo htmlspecialchars($estudiante_info['nombre'] . " " . $estudiante_info['apellido']); ?>
                            </td>
                            <td class="label-cell">Grado</td>
                            <td class="data-cell">
                                <?php echo htmlspecialchars($estudiante_info['grado']); ?>
                            </td>
                        </tr>
                        <tr class="info-row">
                            <td class="label-cell">Proyecto Principal</td>
                            <td colspan="5" class="data-cell">
                                <?php echo htmlspecialchars($proyecto_principal_nombre); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="section-title-cell">INFORME DE ACTIVIDADES</td>
                        </tr>
                        <tr>
                            <th>Fecha de actividad<br />(día/mes/año)</th>
                            <th>Cantidad de horas</th>
                            <th>Trabajo realizado</th>
                            <th colspan="2">Proyecto</th>
                            <th>Docente o persona<br />encargada del reporte</th>
                        </tr>
                        <?php if (!empty($informes_del_estudiante)): ?>
                            <?php foreach ($informes_del_estudiante as $informe): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($informe['fecha']))); ?></td>
                                    <td><?php echo htmlspecialchars($informe['cantidad_horas']); ?></td>
                                    <td><?php echo htmlspecialchars($informe['trabajo_realizado']); ?></td> <td colspan="2"><?php echo htmlspecialchars($informe['nombre_proyecto']); ?></td>
                                    <td><?php echo htmlspecialchars($informe['nombre_docente'] . " " . $informe['apellido_docente']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="total-row">
                                <td colspan="2" class="label-cell">Horas Acumuladas Totales:</td>
                                <td class="data-cell"><?php echo htmlspecialchars($horas_acumuladas_total); ?></td>
                                <td colspan="3"></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">No se encontraron informes para este estudiante.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p style="text-align: center; margin-top: 20px;">No se ha seleccionado ningún estudiante o el estudiante no existe.</p>
            <p style="text-align: center;"><a href="informes.php" class="button">Volver a la selección de estudiantes</a></p>
        <?php endif; ?>
    </div>
</body>
</html>