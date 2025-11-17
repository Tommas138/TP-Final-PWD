<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$exito = false;
$abmCompraEstado = new AbmCompraEstado();

$arrayCarrito = ['idcompra' => $datos['idcompraitem'], 'idcompraestadotipo' => 1];
$exito = $abmCompraEstado->alta($arrayCarrito);

if ($exito) {
    $message = 'Se envio el carrito correctamente';
    header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al enviar su carrito';
    header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    exit;
}