<?php

Class ControlIngresoAdmin {
    public function verificarIngreso($pagina) {
        $session = new Session();

        if (!$session->activa()) {
            header('Location: ../home/index.php');
            exit;
        }
//print_r($session->getusRoles()[0]->getObjRol());
        if ($session->getUsRoles()[0]->getObjRol()->getIdRol() != 1) {
            header('Location: ../home/index.php');
           exit;
        } else {
            header('Location: ../admin/' . $pagina . '.php?verificado=1');
           exit;
        }
    }
}