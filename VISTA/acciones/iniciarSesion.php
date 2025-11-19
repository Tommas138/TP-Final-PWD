<?php 

 require_once __DIR__ . '/../../UTILS/funciones.php';

    $abmrol = new AbmUsuarioRol();
    $sesion = new Session();
    $usuario = data_submitted(); // Array ( [usnombre] => jeremias herrera [usmail] => emai123l@gmail.com [uspass] => 123 )
    $abmUsuario = new AbmUsuario();
   // print_r($usuario);
    $respuesta = $abmUsuario->buscar($usuario);
    //echo $respuesta[0]->getIdUsuario();
    // $buscarrol = ['idusuario' => $respuesta[0]->getIdUsuario()];
    //Array ( [0] => Usuario Object ( [idusuario:Usuario:private] => 2 [usnombre:Usuario:private] => ZAROTH400 [uspass:Usuario:private] => 202 [usmail:Usuario:private] => ZAROTH400@gmail.com [usdeshabilitado:Usuario:private] => 0000-00-00 00:00:00 [mensajeoperacion:Usuario:private] => ) ) Session Object ( )

    // print_r($respuesta[0]->getIdUsuario());

    // print_r($sesion);

    // print_r($abmrol->buscar($buscarrol));


    if($respuesta){
        $sesion->iniciar($respuesta[0]->getIdUsuario(), $respuesta[0]->getUsNombre(), $respuesta[0]->getUsPass()); 
        header("Location: ../home/index.php");
    }else{
        header("Location: ../../index.php");
    }



    
    

?>