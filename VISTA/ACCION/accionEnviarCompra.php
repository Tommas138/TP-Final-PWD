<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmComprasIniciadas = new AbmCompraEstado();
$respuestaEnviarCompra = $abmComprasIniciadas->enviarCompra($datos);

if ($respuestaEnviarCompra) {
    $message = "Compra enviada exitosamente";
    header('Location: ../managerDeposito/administrarCompras.php?Message=' . urlencode($message));
    exit;
} else {
    $message = "No se pudo enviar la compra";
    header('Location: ../managerDeposito/administrarCompras.php?Message=' . urlencode($message));
    exit;
}