<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmCompraItem = new AbmCompraItem();

$sumado = $abmCompraItem->sumarItem($datos);

if ($sumado) {
    $message = "Item modificado";
    header('Location: ../carrito.php?Message=' . urlencode($message));
    exit;
} else {
    $message = "Error al modificar el item";
    header('Location: ../carrito.php?Message=' . urlencode($message));
    exit;
}