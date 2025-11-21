<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmComprasIniciadas = new AbmCompraEstado();

$respuestaAceptarCompra = $abmComprasIniciadas->aceptarCompra($datos);

if ($respuestaAceptarCompra) {
    $message = "Compra aceptada exitosamente";
    header('Location: ../administrarCompras.php?Message=' . urlencode($message));
    exit;
} else {
    $message = "No se pudo aceptar la compra";
    header('Location: ../administrarCompras.php?Message=' . urlencode($message));
    exit;
}