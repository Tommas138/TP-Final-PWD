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

    public function set($idmenu, $menombre, $idpadre,$medescripcion,$medeshabilitado, $menurl) {
        $this->setIdMenu($idmenu);
        $this->setMenombre($menombre);
        $this->setIdPadre($idpadre);
        $this->setMedescripcion($medescripcion);
        $this->setMedeshabilitado($medeshabilitado);
        $this->setMenUrl($menurl);
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

    public function setMeNombre($menombre){
        $this->menombre = $menombre;
    }

    public function setMenUrl($menurl){
        $this->menurl = $menurl;
    }
    public function getMenUrl(){
        return $this->menurl;
    }


    public function setIdPadre($idPadre) {
        $this->idpadre = $idPadre;
    }

    public function getIdMenu() {
        return $this->idmenu;
    }

    public function getMeNombre() {
        return $this->menombre;
    }

    public function getMedescripcion(){
        return $this->medescripcion;
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
        // Prepare idpadre value: may be an object (Menu) or scalar/null
        $idPadreVal = $this->getIdPadre();
        if (is_object($idPadreVal) && method_exists($idPadreVal, 'getIdMenu')) {
            $idPadreVal = $idPadreVal->getIdMenu();
        }
        $idPadreSql = ($idPadreVal === null || $idPadreVal === "" ) ? "NULL" : "'" . $idPadreVal . "'";

        // Use correct getter for nombre and close the VALUES parenthesis
        $sql = "INSERT INTO menu (idmenu, menombre, medescripcion, idpadre, medeshabilitado, menurl) VALUES ('" . $this->getIdMenu() . "','" . $this->getMeNombre() . "','" . $this->getMedescripcion() . "'," . $idPadreSql . ",'" . $this->getMedeshabilitado() . "', " . $this->getMenUrl() . "')";
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
        // Prepare idpadre value for SQL
        $idPadreVal = $this->getIdPadre();
        if (is_object($idPadreVal) && method_exists($idPadreVal, 'getIdMenu')) {
            $idPadreVal = $idPadreVal->getIdMenu();
        }
        $idPadreSql = ($idPadreVal === null || $idPadreVal === "") ? "NULL" : "'" . $idPadreVal . "'";

        // Build a proper UPDATE statement and use WHERE to target this menu
        $sql = "UPDATE menu SET menombre='" . $this->getMeNombre() . "', medescripcion='" . $this->getMedescripcion() . "', idpadre=" . $idPadreSql . ", medeshabilitado='" . $this->getMedeshabilitado() . "', menurl = " . $this->getMenUrl() . "' WHERE idmenu = '" . $this->getIdMenu() . "'";
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
                $this->set($fila['idmenu'], $fila['menombre'], $fila['idpadre'], $fila['medescripcion'], $fila["medeshabilitado"], $fila['menurl']);
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
                $obj->set($row['idmenu'], $row['menombre'], $row["idpadre"],$row["medescripcion"],$row["medeshabilitado"], $row['menurl']);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("Menu->Listar: " . $base->getError());
        }
        
        return $arreglo;
    }

    public function estado($param = "")
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE menu SET medeshabilitado='" . $param . "' WHERE idmenu=" . $this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->estado: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->estado: " . $base->getError());
        }

        return $resp;
    }
}
