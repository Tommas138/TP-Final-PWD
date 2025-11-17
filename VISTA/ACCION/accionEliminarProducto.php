
<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmProducto = new AbmProducto();

$exito = $abmProducto->baja($datos);

if ($exito) {
    $message = 'Eliminacion exitosa';
    header("Location: ../managerDeposito/administrarProductos.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Eliminacion erronea';
    header("Location: ../managerDeposito/administrarProductos.php?Message=" . urlencode($message));
    exit;
}
