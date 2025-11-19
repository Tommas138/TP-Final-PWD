<?php

Class ControlIngresoCliente {

    public function verificarIngreso($pagina) {
        $session = new Session();
        if (!$session->activa()) {
            header('Location: ../home/index.php');
            exit;
        }

        //cambiar el != 1 a != 3
        if ($session->getUsRoles()[0]->getObjRol()->getIdRol() != 1) {
            if (isset($session->getUsRoles()[1])) {
                if ($session->getUsRoles()[1]->getObjRol()->getIdRol() != 1) {
                    header('Location: ../home/index.php');
                    exit;
                }
                header('Location: ../cliente/' . $pagina . '.php?verificado=1');
                exit;
            }
            header('Location: ../home/index.php');
            exit;
        } else {
            header('Location: ../cliente/' . $pagina . '.php?verificado=1');
            exit;
        }
    }
}