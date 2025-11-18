<?php


    include_once '../../CONTROL/Session.php';

    $sesion = new Session();
    $sesion->cerrarSession();
    header("Location: ../../index.php");
    exit();