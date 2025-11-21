<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$abmUsuario = new AbmUsuario();
$abmUsuarioRol = new AbmUsuarioRol();


$exitoModificacionUsuario = $abmUsuario->modificacion($datos);
$exitoModificacionUsuarioRol = $abmUsuarioRol->modificacion($datos);
if ($exitoModificacionUsuario || $exitoModificacionUsuarioRol) {
    header('Location: ../administrarUsuarios.php?messageOk=' . urlencode("Usuario modificado correctamente"));
    exit;
} else {
    header('Location: ../administrarUsuarios.php?messageErr=' . urlencode("Error en la modificación"));
    exit;
}