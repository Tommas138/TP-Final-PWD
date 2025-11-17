<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$sesion = new Session();
if (!$sesion->activa()) {
    $message = "No ha iniciado sesion";
    header('Location: ../login/login.php?Message=' . urlencode($message));
}

$datos = data_submitted();
$abmComprasIniciadas = new AbmCompraEstado();
$respuestaFinCompra = $abmComprasIniciadas->finCompra($datos);

if ($respuestaFinCompra) {
    $message = "Compra finalizada exitosamente";
    header('Location: ../home/index.php?Message=' . urlencode($message));
    exit;
} else {
    $message = "No se pudo finalizar la compra";
    header('Location: ../home/index.php?Message=' . urlencode($message));
    exit;
}