<?php
require_once("conex.php"); // Asegúrate de que esta ruta es correcta

$todos_los_estudiantes = [];
$search_query = "";
$filter_type = "name"; // Default filter type

// Check if a search was submitted
if (isset($_GET['search_button'])) { // Changed from POST to GET for search form
    $search_query = $_GET['search_input'] ?? '';
    $filter_type = $_GET['filter_type'] ?? 'name';

    $sql_all_estudiantes = "SELECT id_estudiante, nombre, apellido, grado FROM Estudiante";
    $params = [];
    $types = "";

    if (!empty($search_query)) {
        $search_query = "%" . $search_query . "%"; // Add wildcards for LIKE search

        if ($filter_type === "name") {
            // Search by name (nombre or apellido)
            $sql_all_estudiantes .= " WHERE nombre LIKE ? OR apellido LIKE ?";
            $params = [$search_query, $search_query];
            $types = "ss";
        } elseif ($filter_type === "ID") {
            // Search by ID (exact match for ID, but still use LIKE for consistency or adjust if exact match is needed)
            $sql_all_estudiantes .= " WHERE id_estudiante LIKE ?";
            $params = [$search_query]; // For ID, you might want to use exact match: WHERE id_estudiante = ?
            $types = "s"; // Change to "i" for exact int match if preferred: $params = [(int)str_replace('%', '', $search_query)];
        }
    }
    $sql_all_estudiantes .= " ORDER BY nombre ASC"; // Always order

    if ($stmt = $con->prepare($sql_all_estudiantes)) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $res_all_estudiantes = $stmt->get_result();
        if ($res_all_estudiantes->num_rows > 0) {
            while ($row = $res_all_estudiantes->fetch_assoc()) {
                $todos_los_estudiantes[] = $row;
            }
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $con->error;
    }

} else {
    // No search submitted, fetch all students
    $sql_all_estudiantes = "SELECT id_estudiante, nombre, apellido, grado FROM Estudiante ORDER BY nombre ASC";
    $res_all_estudiantes = $con->query($sql_all_estudiantes);
    if ($res_all_estudiantes && $res_all_estudiantes->num_rows > 0) {
        while ($row = $res_all_estudiantes->fetch_assoc()) {
            $todos_los_estudiantes[] = $row;
        }
    }
}
$con->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../style/tablas.css" />
<link rel="stylesheet" href="../style/barra-busqueda.css" />
<link rel="icon" href="../assets/logo.png" type="image/x-icon">
<title>INFORMES</title>
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
            <div class="button-logo profesores"></div>
            <a class="button" href="docentes.php">DOCENTES</a>
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
            <div class="button-logo informesV"></div>
            <a class="button" href="add-informe.php">NUEVO INFORME</a>
        </div>
    </div>
</header>

<div class="content">
<h1 class="titulo">INFORMES</h1>

    <div class="search-filter-container">
        <form action="informes.php" method="GET" class="search-form"><div class="filter-group left-filters">
        <label for="filter_type">Buscar por:</label>
                <select id="filter_type" name="filter_type">
                    <option value="name" <?php echo ($filter_type === 'name') ? 'selected' : ''; ?>>Nombre</option>
                    <option value="ID" <?php echo ($filter_type === 'ID') ? 'selected' : ''; ?>>ID</option>
        </select>
    </div>

    <div class="search-bar">
        <input type="text" id="search_input" name="search_input" placeholder="Buscar estudiantes..." value="<?php echo htmlspecialchars(str_replace('%', '', $search_query)); ?>">
        <button type="submit" name="search_button" class="search-button"></button> </div>
        </form>
</div>

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
    <?php if (!empty($todos_los_estudiantes)): ?>
        <?php foreach ($todos_los_estudiantes as $estudiante): ?>
        <tr>
        <td><?php echo htmlspecialchars($estudiante['id_estudiante']); ?></td>
        <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
        <td><?php echo htmlspecialchars($estudiante['apellido']); ?></td>
        <td><?php echo htmlspecialchars($estudiante['grado']); ?></td>
        <td>
                    <a href="informe-tabla.php?estudiante_id=<?php echo htmlspecialchars($estudiante['id_estudiante']); ?>" 
            title="Generar informe" class="accion"><img class="sub-button" src="../assets/informes-logo-hover.png"></a>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <tr>
        <td colspan="5" style="text-align: center;">No se encontraron estudiantes.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</div>
</div>
</body>
</html>