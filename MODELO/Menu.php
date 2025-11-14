<?php

class Menu {
    private $idmenu;
    private $menombre;
    private $menurl;
    private $idpadre; // puede ser null o un objeto Menu

    public function __construct() {
    }

    public function set($idmenu, $menombre, $menurl, $idpadre) {
        $this->setIdMenu($idmenu);
        $this->setMenombre($menombre);
        $this->setMenurl($menurl);
        $this->setIdPadre($idpadre);
    }

    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
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

    public function getMenUrl() {
        return $this->menurl;
    }

    public function getIdPadre() {
        return $this->idpadre;
    }

    // Los siguientes métodos son implementaciones mínimas/placeholder.
    // Si ya existe una clase BaseDatos y convenciones, reemplazar/implementar con consultas reales.

    public function insertar() {
        // TODO: implementar inserción real en la DB
        return true;
    }

    public function modificar() {
        // TODO: implementar actualización real en la DB
        return true;
    }

    public function eliminar() {
        // TODO: implementar eliminación real en la DB
        return true;
    }

    public function cargar() {
        // TODO: implementar carga real desde la DB usando $this->idmenu
        return true;
    }

    public static function listar($where = " true ") {
        // TODO: implementar listado real con BaseDatos
        return [];
    }
}
