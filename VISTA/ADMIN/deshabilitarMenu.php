<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

include_once '../ACCION/ESTRUCTURA/reusables/header.php';
$datos = data_submitted();
$abmMenu = new AbmMenu();

$arrayBusqueda = ["idmenu" => $datos['idmenu']];

?>

<?php
$respuestaDeshabilitado = $abmMenu->deshabilitarMenu($arrayBusqueda);

if ($respuestaDeshabilitado) {
    $message = "Deshabilitacion exitosa";
    header('Location: ../admin/administrarMenus.php?Message=' . urlencode($message));
} else {
    $message = "Deshabilitacion erronea";
    header('Location: ../admin/administrarMenus.php?Message=' . urlencode($message));
}
?>

<?php



?>