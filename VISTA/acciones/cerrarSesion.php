<?php


require_once __DIR__ . '/../../UTILS/funciones.php';

    $sesion = new Session();
    $sesion->cerrarSession();
    header("Location: ../../index.php");
    exit();