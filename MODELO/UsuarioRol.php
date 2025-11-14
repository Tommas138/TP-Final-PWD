<?php

Class UsuarioRol {
    private $idRol;
    private $idUsuario;
    private $mensajeOperacion;

    public function __construct() {
        $this->idUsuario = "";
        $this->idRol = "";
        $this->mensajeOperacion = "";
    }

    public function getObjUsuario() {
        return $this->idUsuario();
    }
    public function getObjRol() {
        return $this->idRol;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setObjUsuario($objUsuario) {
        $this->objUsuario = $objUsuario;
    }
    public function setObjRol($objRol) {
        $this->objRol = $objRol;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function set($idUsuario, $idRol) {
        $this->setObjUsuario($idUsuario);
        $this->setObjRol($idRol);
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getObjUsuario()->getIdusuario() . " AND idrol = " . $this->getObjRol()->getIdRol();

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
                if ($res > 0) {
                    $row = $base->Registro();
                    $objUsuario = null;
                    if ($row['idusuario'] != null) {
                        $objUsuario - new Usuario();
                        $objUsuario->setIdUsuariuo($row['idusuario']);
                        $objUsuario->cargar();
                    }
                    $objRol = null;
                    if ($row['idrol'] != null) {
                        $objRol = new Rol();
                        $objRol->setIdRol($row['idrol']);
                        $objRol->cargar();
                    }
                    $this->set($row['idusuario'], $row['idrol']);;
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Cargar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuariorol (idusuario, idrol) VALUES ('" . $this->getObjUsuario()->getIdUsuario() . "', '" . $this->getObjRol()->getIdRol() . "')";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->Insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Insertar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE * FROM idusuario = " . $this->getObjUsuario()->getIdUsuario() . " AND idrol = " . $this->getObjRol()->getIdRol();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->Eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($param) {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        if ($param != "") {
            $sql .= ' WHERE ' . $param;
        }

        $res = $base->Ejecutar($sql);

        if ($res > 0) {
            while ($row = $base->Registro()) {
                $objUsuario = null;
                if ($row['idusuario'] != null) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->cargar();
                }
                $objRol = null;
                if ($row['idrol'] != null) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();
                }
                $obj = new UsuarioRol();
                $obj->set($objUsuario, $objRol);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $idUsuario = $this->getObjUsuario()->getIdUsuario();
        $idRol = $this->getObjRol()->getIdRol();
        $sql = "UPDATE usuariorol SET idrol = " . $idRol . " WHERE idusuario = " . $idUsuario;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->Modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Modificar: " . $base->getError());
        }
        return $resp;
    }
}