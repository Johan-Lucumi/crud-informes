<?php
require_once("conex.php");

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: proyectos.php?eliminado=0");
    exit();
}

$stmt = $con->prepare("DELETE FROM Proyecto WHERE id_proyecto = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: proyectos.php?eliminado=1");
} else {
    header("Location: proyectos.php?eliminado=0");
}
$stmt->close();
?>