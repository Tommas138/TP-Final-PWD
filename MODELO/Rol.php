<?php

Class Rol {
    private $idRol;
    private $rolDescripcion;
    private $mensajeOperacion;

    public function __construct() {
        $this->idRol = "";
        $this->rolDescripcion = "";
        $this->mensajeOperacion = "";
    }

    public function getIdRol() {
        return $this->idRol;
    }
    public function getRolDescripcion() {
        return $this->rolDescripcion;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //Setters
    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }
    public function setRolDescripcion($rolDescripcion) {
        $this->rolDescripcion = $rolDescripcion;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //Metodo set pa ahorrar tiempo
    public function set($idRol, $rolDescripcion) {
        $this->setIdRol($idRol);
        $this->setRolDescripcion($rolDescripcion);
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol where idrol = " . $this->getIdRol();

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $row = $base->Registro();
                $this->set(
                    $row['idrol'],
                    $row['roldescripcion']
                );
            }
        } else {
            $this->setMensajeOperacion("Rol->Listar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE rol SET roldescripcion = '{$this->getRolDescripcion()}' WHERE idrol = '" . $this->getIdRol() . "'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->Modificar: " . $base->getError());
            }
        } else {
           $this->setMensajeOperacion("Rol->Modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE * FROM rol WHERE idrol = '" . $this->getIdRol() . "'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->Eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->Eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($param) {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol ";
        if ($param != "") {
            $sql .= ' WHERE ' . $param;
        }
        $res = $base->Ejecutar($sql);
        if ($res > 0 ) {
            while ($row = $base->Registro()) {
                $objRol = new Rol();
                $objRol->set(
                    $row['idrol'],
                    $row['roldescripcion']
                );
                array_push($arreglo, $objRol);
            }
        } else {
            $this->setMensajeOperacion("Rol->Listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO rol (roldescripcion) VALUES ('" . $this->getRolDescripcion() . "'";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdRol($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->Insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->Insertar: " . $base->getError());
        }

        return $resp;
    }
}