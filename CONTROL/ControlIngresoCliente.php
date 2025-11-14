<?php

Class ControlIngresoCliente {

    public function verificarIngreso($pagina) {
        $session = new Session();
        if (!$session->activa()) {
            header('Location: ../index.php');
            exit;
        }

        if ($session->getUsRoles()[0] != 3) {
            if (isset($session->getUsRoles()[1])) {
                if ($session->getUsRoles()[1] != 3) {
                    header('Location: ../home/index.php');
                    exit;
                }
                header('Location: ../cliente/' . $pagina . '.php?verificado=1');
                exit;
            }
            header('Location: ../index.php');
            exit;
        } else {
            header('Location: ../cliente/' . $pagina . '.php?verificado=1');
            exit;
        }
    }
}