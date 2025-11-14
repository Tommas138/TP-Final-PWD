<?php

class Session {
    public function __construct() {
        session_start();
    }

    public function iniciar($nombreUsuario, $psw) {
        $_SESSION['usuario'] = $nombreUsuario;
        $_SESSION['psw'] = $psw;
    }

    public function validar() {
        return isset($_SESSION['usuario']) && isset($_SESSION['psw']);
    }

    public function activa() {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function getUsuario() {
        return $_SESSION['usuario'] ?? null;
    }

    public function getPass() {
        return $_SESSION['psw'] ?? null;
    }

    public function getRol() {
        return $_SESSION['rol'] ?? null;
    }

    public function cerrar() {
        session_unset();
        session_destroy();
    }    

    public function sessionId() {
        return session_id();
    }   
}