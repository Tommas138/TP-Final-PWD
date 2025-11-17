<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();

$sesion = new Session();
if (!$sesion->activa()) {
    $message = "No ha iniciado sesion";
    header('Location: ../login/login.php?Message=' . urlencode($message));
}
$abmUsuario = new AbmUsuario();
$idUsuarioSesion = $sesion->getIdUsuario();
if (isset($datos)) {
    $datos['idusuariosesion'] = $idUsuarioSesion;
    $exito = $abmUsuario->baja($datos);

    if ($exito) {
        $message = 'Eliminacion exitosa';
        header("Location: ../admin/administrarUsuarios.php?Message=" . urlencode($message));
        exit;
    } else {
        $message = 'Eliminacion erronea';
        header("Location: ../admin/administrarUsuarios.php?Message=" . urlencode($message));
        exit;
    }
}