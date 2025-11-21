<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();

$abmProducto = new AbmProducto();
$datos['files'] = $_FILES;

//print_r($datos);
$exito = $abmProducto->modificacion($datos);

if ($exito) {
    header('Location: ../administrarProductos.php?message=' . urlencode("Producto modificado"));
    exit;
} else {
    header('Location: ../administrarProductos.php?message=' . urlencode("Error en la modificacion"));
    exit;
}