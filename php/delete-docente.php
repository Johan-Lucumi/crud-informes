<?php
require_once("conex.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $con->prepare("DELETE FROM Docente WHERE id_docente = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: docentes.php?eliminado=1");
        exit();
    } else {
        header("Location: docentes.php?eliminado=0");
        exit();
    }

    $stmt->close();
} else {
    header("Location: docentes.php?eliminado=0");
    exit();
}
?>
