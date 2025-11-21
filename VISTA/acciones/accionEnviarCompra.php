<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$datos = data_submitted();

$resp = false;
$abmCompraEstado = new AbmCompraEstado();

if (isset($datos['idcompraestado'])) {
    // Llamamos a la función corregida
    if ($abmCompraEstado->enviarCompra($datos)) {
        $resp = true;
    }
}

if ($resp) {
    $mensaje = "La compra pasó a estado Enviada.";
} else {
    $mensaje = "Error al cambiar el estado de la compra.";
}

// Redireccionar de vuelta a la administración
echo "<script>
        window.location.href = '../index.php?Message=" . urlencode($mensaje) . "';
      </script>";
?>