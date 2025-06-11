<?php
require_once("conex.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $con->prepare("DELETE FROM Estudiante WHERE id_estudiante = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: estudiantes.php?eliminado=1");
    } else {
        // Redirigir con mensaje de error (opcional)
        header("Location: estudiantes.php?error=1");
    }
    $stmt->close();
} else {
    header("Location: estudiantes.php");
}
?>
