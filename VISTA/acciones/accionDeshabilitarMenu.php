<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$datos = data_submitted();
$abmMenu = new AbmMenu();

$arrayBusqueda = ["idmenu" => $datos['idmenu']];

?>

<?php
$respuestaDeshabilitado = $abmMenu->deshabilitarMenu($arrayBusqueda);

if ($respuestaDeshabilitado) {
    $message = "Deshabilitacion exitosa";
    header('Location: ../administrarMenus.php?Message=' . urlencode($message));
} else {
    $message = "Deshabilitacion erronea";
    header('Location: ../administrarMenus.php?Message=' . urlencode($message));
}
?>

<?php



?>