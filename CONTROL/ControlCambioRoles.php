<?php

$session = new Session();

if ($session->activa()) {
    header('Location: ../VISTA/home/index.php?message=' . urlencode('Sesion no iniciada'));
    exit;
} else {
    $datos = data_submitted();
    $roles = $session->getUsRoles();
    $rolesSession = array($roles[0]);
    switch($datos['rol']) {
        case md5(1):
            if ($rolesSession[0] != 1) {
                $rolesSession[1] = 1;
                $session->setUsRoles($rolesSession);
                print_r($session->getUsRoles());
            } else {
                $rolesSession = array($roles[0]);
                $session->setUsRoles($rolesSession);
            }
            break;
        case md5(2):
            if ($rolesSession[0] != 2) {
                $rolesSession[1] = 2;
                $session->setUsRoles($rolesSession);
                print_r($session->getUsRoles());
            } else {
                $rolesSession = array($roles[0]);
                $session->setUsRoles($rolesSession);
            }
            break;
        case md5(3):
            if ($rolesSession[0] != 3) {
                $rolesSession[1] = 3;
                $session->setUsRoles($rolesSession);
                print_r($session->getUsRoles());
            } else {
                $rolesSession= array($roles[0]);
                $session->setUsRoles($rolesSession);
            }
            break;
    }

    header('Location: ../VISTA/home/index.php?message=' . urlencode("Cambio de rol con exito"));
    exit;
}