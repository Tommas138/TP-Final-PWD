<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$titulo = 'Deshabilitar Usuario';

$datos = data_submitted();

$sesion = new Session();
if (!$sesion->activa()) {
    $message = "Sesion no iniciada";
    header('Location: ../login/login.php?Message=' . urlencode($message));
}

$abmUsuario = new AbmUsuario();
$arrayBusqueda = ["idusuario" => $datos['idusuario']];

?>

<?php
$idUsuarioSesion = $sesion->getIdUsuario();

if (isset($datos)) {
    if ($datos['idusuario'] == $idUsuarioSesion) {
        $message = "No se puede deshabilitar a si mismo";
        header('Location: ../administrarUsuarios.php?Message=' . urlencode($message));
        exit;
    }
    $respuestaDeshabilitado = $abmUsuario->deshabilitarUsuario($arrayBusqueda);
    if ($respuestaDeshabilitado) {
        $message = "Deshabilitacion exitosa";
        header('Location: ../administrarUsuarios.php?Message=' . urlencode($message));
    } else {
        $message = "Deshabilitacion erronea";
        header('Location: ../administrarUsuarios.php?Message=' . urlencode($message));
    }
}
?>

<?php

include_once '../estructura/footer.php';

?>