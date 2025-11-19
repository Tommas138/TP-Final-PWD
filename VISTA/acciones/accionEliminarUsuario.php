<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted(); //Array ( [idusuario] => 2 )

$sesion = new Session();
$usuario = new AbmUsuario();

if (!$sesion->activa()) {
    $message = "No ha iniciado sesion";
    header('Location: ../login/login.php?Message=' . urlencode($message));
}
$abmUsuario = new AbmUsuario();
$idUsuarioSesion = $sesion->getIdUsuario();
print_r($datos);
if (isset($datos)) {
    // $datos['idusuariosesion'] = $idUsuarioSesion;
    // $exito = $abmUsuario->baja($datos);
    $usuario->eliminarPorID($datos["idusuario"]);
    
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