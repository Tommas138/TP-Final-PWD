<?php

Class ControlIngresoAdmin {
    public function verificarIngreso($pagina) {
        $session = new Session();

        if (!$session->activa()) {
            header('Location: ../index.php');
            exit;
        }
//print_r($session->getusRoles()[0]->getObjRol());
        if ($session->getUsRoles()[0]->getObjRol()->getIdRol() != 1) {
            header('Location: ../index.php');
           exit;
        } else {
        
        }
    }
}