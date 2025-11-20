<?php

Class ControlIngresoManagerDeposito {

    public function verificarIngreso($pagina) {
        $session = new Session();

        if (!$session->activa()) {
            header('Location: ../home/index.php');
            exit;
        }

        if ($session->getUsRoles()[0]->getObjRol()->getIdRol() != 2 || $session->getUsRoles()[0]->getObjRol()->getIdRol() != 1 ) {
            if (isset($session->getUsRoles()[1])) {
                if ($session->getUsRoles()[1]->getObjRol()->getIdRol() != 2 || $session->getUsRoles()[0]->getObjRol()->getIdRol() != 1) {
                    header('Location: ../home/index.php');
                    exit;
                }
                header('Location: ../managerDeposito/' . $pagina . '.php?verificado=1');
                exit;
            }
        }
    }
}