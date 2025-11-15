<?php

class Menu {
    private $idmenu;
    private $menombre;
    private $menurl;
    private $medescripcion;
    private $medeshabilitado;
    private $idpadre; // puede ser null o un objeto Menu
    private $mensajeoperacion;

    public function __construct() {
    }

    public function set($idmenu, $menombre, $menurl, $idpadre,$medescripcion,$medeshabilitado) {
        $this->setIdMenu($idmenu);
        $this->setMenombre($menombre);
        $this->setMenurl($menurl);
        $this->setIdPadre($idpadre);
        $this->setMedescripcion($medescripcion);
        $this->setMedeshabilitado($medeshabilitado);
    }

    public function setMedescripcion($medescripcion){
        $this->medescripcion = $medescripcion;
    }

    public function setMensajeOperacion($mensaje){
        $this->mensajeoperacion = $mensaje;
    }
    public function setMedeshabilitado($medeshabilitado){
        $this->medeshabilitado = $medeshabilitado;
    }

    public function setIdMenu($idMenu){
        $this->idmenu = $idMenu;
    }

    public function setMenombre($menombre){
        $this->menombre = $menombre;
    }

    public function setMenurl($menurl) {
        $this->menurl = $menurl;
    }

    public function setIdPadre($idPadre) {
        $this->idpadre = $idPadre;
    }

    public function getIdMenu() {
        return $this->idmenu;
    }

    public function getMenNombre() {
        return $this->menombre;
    }

    public function getMedescripcion(){
        return $this->medescripcion;
    }

    public function getMenUrl() {
        return $this->menurl;
    }

    public function getIdPadre() {
        return $this->idpadre;
    }

    public function getMedeshabilitado(){
        return $this->medeshabilitado;
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menu (idmenu, menombre, medescripcion, idpadre, medeshabilitado ) VALUES ('" . $this->getIdMenu() . "','" . $this->getMenNombre() . "','" . $this->getMedescripcion() . "','" . $this->getIdPadre() . "','" . $this->getMedeshabilitado();
        if($base->Iniciar()) {
            if($elid = $base->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("menu->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE menu SET idmenu= '" . $this->getIdMenu() . "', menombre='" . $this->getMenNombre() . "', medescripcion='" . $this->getMedescripcion() . "', idpadre= '" . $this->getIdPadre() . "', medeshabilitado=  '".$this->getMedeshabilitado() ."";
        if($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeOperacion("menu->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menu WHERE idmenu=" . $this->getIdMenu();
        if($base->Iniciar()) {
            if($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu WHERE idmenu=" . $this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $fila = $base->Registro();
                $this->set($fila['idmenu'], $fila['menombre'], $fila['menurl'], $fila['idpadre'], $fila['medescripcion'], $fila["medeshabilitado"]);
            }
        } else {
            $this->setMensajeOperacion("usuario->cargar: " . $base->getError());
        }
        return $resp;
    }

    public function listar($param = "") {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu ";
        if ($param != "") {
            $sql .= 'WHERE ' . $param;
        }
        $res = $base->Ejecutar($sql);
        if ($res > 0) {
            while ($row = $base->Registro()) {
                $obj = new Menu();
                $obj->set($row['idmenu'], $row['menombre'], $row['menurl'], $row["idpadre"],$row["medescripcion"],$row["medeshabilitado"]);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("Menu->Listar: " . $base->getError());
        }
        return $arreglo;
    }
}
