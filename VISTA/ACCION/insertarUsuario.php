<?php 

    include_once '../../CONTROL/AbmUsuario.php';
    include_once '../../UTILS/funciones.php';
    include_once '../../CONTROL/Session.php';

    $sesion = new Session();
    $usuario = data_submitted(); // Array ( [usnombre] => jeremias herrera [usmail] => emai123l@gmail.com [uspass] => 123 )
    // print_r($usuario);
    $abmUsuario = new AbmUsuario();
    $respuesta = $abmUsuario->alta($usuario);

    if($respuesta){
        header("Location: ../../index.php");
        $sesion->iniciar($usuario['usnombre'], $usuario['uspass']);
    }
?>