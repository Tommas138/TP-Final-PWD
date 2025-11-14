<?php
Class Producto {
    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;
    private $mensajeOperacion;
    public function __construct(){

    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto WHERE idproducto=" . $this->getIdProducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $fila = $base->Registro();
                $this->set($fila['idproducto'], $fila['pronombre'], $fila['prodetalle'], $fila['procantstock']);
            }
        } else {
            $this->setMensajeOperacion("producto->cargar: " . $base->getError());
        }
        return $resp;
    }

    public function set($idproducto, $pronombre, $prodetalle, $procantstock) {
        $this->idproducto = $idproducto;
        $this->pronombre = $pronombre;
        $this->prodetalle = $prodetalle;
        $this->procantstock = $procantstock;
    }

    // getters y setters individuales
    public function getIdProducto() {
        return $this->idproducto;
    }
    public function setIdProducto($idproducto) {
        $this->idproducto = $idproducto;
    }

    public function getPronombre() {
        return $this->pronombre;
    }
    public function setPronombre($pronombre) {
        $this->pronombre = $pronombre;
    }

    public function getProdetalle() {
        return $this->prodetalle;
    }
    public function setProdetalle($prodetalle) {
        $this->prodetalle = $prodetalle;
    }

    public function getProcantstock() {
        return $this->procantstock;
    }
    public function setProcantstock($procantstock) {
        $this->procantstock = $procantstock;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
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
                $obj = new Producto();
                $obj->set($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row["procantstock"]);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("Producto->Listar: " . $base->getError());
        }
        return $arreglo;
    }
}