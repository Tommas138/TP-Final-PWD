<?php

Class ControlIngresoCliente {

    public function verificarIngreso($pagina) {
        $session = new Session();
        if (!$session->activa()) {
            header('Location: ../index.php');
            exit;
        }
                }
}