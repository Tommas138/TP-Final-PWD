
<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$datos = data_submitted();

$abmMenu = new AbmMenu();
$exito = $abmMenu->alta($datos);

if ($exito) {
    $message = "Menu cargado correctamente";
    header('Location: ../administrarMenus.php?messageOk=' . urlencode($message)); 
    exit;
} else {
    $message = "Error carga menú";
    header('Location: ../nuevoMenu.php?messageErr=' . urlencode($message));
    exit;
}
