<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmUsuario = new AbmUsuario();

$exito = false;
$exito = $abmUsuario->alta($datos);

if ($exito) {
    $message = 'Se cargo correctamente el usuario y el rol';
    header("Location: ../index.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al registrar el usuario';
    header("Location: ../login/registrar.php?Message=" . urlencode($message));
    exit;
}