<?php 

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/../../UTILS/funciones.php';

    $usuario = data_submitted();
    
    // Validar que tenemos datos
    if (empty($usuario['usnombre']) || empty($usuario['usmail']) || empty($usuario['uspass'])) {
        echo "Error: Datos incompletos";
        die();
    }

    $abmUsuario = new AbmUsuario();
    $respuesta = $abmUsuario->alta($usuario);

    print_r($respuesta);


    if($respuesta){
        header("Location: ../home/index.php");
        exit;
    }else{
        echo "Error al registrar usuario";
        die();
    }
?>