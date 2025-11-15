<?php

Class MenuRol {
    
    private $objMenu;
    private $objRol;
    private $mensajeOperacion;

    public function __construct() {
        $this->objMenu = "";
        $this->objRol = "";
        $this->mensajeOperacion = "";
    }

    public function getObjMenu() {
        return $this->objMenu;
    }
    public function getObjRol() {
        return $this->objRol;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setObjMenu($objMenu) {
        $this->objMenu = $objMenu;
    }
    public function setObjRol($objRol) {
        $this->objRol = $objRol;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function set($objMenu, $objRol) {
        $this->objMenu = $objMenu;
        $this->objRol = $objRol;
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol WHERE idmenu = " . $this->getObjMenu()->getIdMenu() . " AND idrol = " . $this->getObjRol()->getIdRol();

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $row = $base->Registro();
                $objMenu = null;

                if ($row['idmenu'] != null) {
                    $objMenu = new Menu();
                    $objMenu->setIdMenu($row['idmenu']);
                    $objMenu->cargar();
                }
            } else {
                $this->setMensajeOperacion("MenuRol->Cargar: " . $base->getError());
            }
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menurol (idmenu, idrol) VALUES ('{$this->getObjMenu()->getIdMenu()}', '{$this->getObjRol()->getIdRol()}');";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("MenuRol->Insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->Insertar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE * FROM menurol WHERE idmenu = " . $this->getObjMenu()->getIdMenu() . " AND idrol = " . $this->getObjRol()->getIdRol();
        if ($base->Iniciar()) {
            if($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("MenuRol->Eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->Eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function listar($param = "") {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol ";

        if ($param != "") {
            $sql .= ' WHERE ' . $param;
        }

        $res = $base->Ejecutar($sql);
        if ($res > 0) {
            while ($row = $base->Registro()) {
                $obj = new MenuRol();
                $objMenu = null;

                if ($row['idmenu'] != null) {
                    $objMenu = new Menu();
                    $objMenu->setIdMenu($row['idmenu']);
                    $objMenu->cargar();
                }
                $objRol = null;
                if ($row['idrol'] != null) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();
                }

                $obj->set($objMenu, $objRol);
                array_push($arreglo, $obj);
            }
        }
        return $arreglo;
    }
    
}