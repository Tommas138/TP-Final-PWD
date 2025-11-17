<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmMenu = new AbmMenu();

$exito = $abmMenu->baja($datos);

if ($exito) {
    $message = 'Eliminacion exitosa';
    header("Location: ../admin/administrarMenus.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Eliminacion erronea';
    header("Location: ../admin/administrarMenus.php?Message=" . urlencode($message));
    exit;
}