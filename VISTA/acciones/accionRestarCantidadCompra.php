<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmCompraItem = new AbmCompraItem();

$restado = $abmCompraItem->restarItem($datos);
print_r($datos);

if ($restado) {
    $message = "Item modificado";
    header('Location: ../cliente/carrito.php?Message=' . urlencode($message));
   exit;
} else {
    $message = "Error al modificar el item";
    header('Location: ../cliente/carrito.php?Message=' . urlencode($message));
    exit;
}