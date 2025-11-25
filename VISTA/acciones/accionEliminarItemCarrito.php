<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmItemCarrito = new AbmCompraItem();
$exito = $abmItemCarrito->baja2($datos);

if ($exito) {
    $message = 'Eliminacion de item de carrito exitosa';
    header("Location: ../carrito.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Eliminacion erronea';
    header("Location: ../carrito.php?Message=" . urlencode($message));
    exit;
}