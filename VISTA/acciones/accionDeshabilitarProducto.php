
<?php
require_once __DIR__ . '/../../UTILS/funciones.php';
include_once '../../CONTROL/AbmProducto.php';

$titulo = 'Deshabilitación de Productos';

$datos = data_submitted();

$abmProducto = new AbmProducto();
$arrayBusqueda = ["idproducto" => $datos['idproducto']];

$respuestaDeshabilitado = $abmProducto->deshabilitarProd($arrayBusqueda);

if ($respuestaDeshabilitado) {
    $message = "Deshabilitacion exitosa";
    header('Location: ../managerDeposito/administrarProductos.php?Message=' . urlencode($message));
    exit;
} else {
    $message = "Deshabilitacion erronea";
    header('Location: ../managerDeposito/administrarProductos.php?Message=' . urlencode($message));
    exit;
}
