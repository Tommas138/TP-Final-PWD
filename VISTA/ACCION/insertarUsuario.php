<?php 

    include_once '../../CONTROL/AbmUsuario.php';
    include_once '../../UTILS/funciones.php';
    include_once '../../CONTROL/Session.php';

    $sesion = new Session();
    $usuario = data_submitted();
    $abmUsuario = new AbmUsuario();
    $respuesta = $abmUsuario->alta($usuario);

    if($respuesta){
        header("Location: ../../index.php");
        $sesion->iniciar($usuario['usnombre'], $usuario['uspass']);
    }
?>