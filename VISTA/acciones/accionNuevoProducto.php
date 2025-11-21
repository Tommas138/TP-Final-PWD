
<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();

$abmProducto = new AbmProducto();

$datos['files'] = $_FILES;
$exito = $abmProducto->alta($datos);

if ($exito) {
    $message = "Producto cargado correctamente";
    header('Location: ../administrarProductos.php?message=' . urlencode($message));
    exit;
} else {
    $message = "Error en la carga del producto";
    header('Location: ../nuevoProducto.php?message=' . urlencode($message));
    exit;
}
