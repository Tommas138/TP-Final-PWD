<?php
class Compra {
    //Definimos los atributos
    private $idCompra;
    private $cofecha;
    private $idUsuario;
    private $mensajeOperacion;

    //Definimos la funcion __construct
    public function __construct() {
        $this->idCompra = "";
        $this->cofecha = "";
        $this->idUsuario = new Usuario();
        $this->mensajeOperacion = "";
    }

    //Definimos las funciones para los gets y sets
    public function getIdCompra () {
        return $this->idCompra;
    }
    public function getCoFecha () {
        return $this->cofecha;
    }
    public function getIdUsuario () {
        return $this->idUsuario;
    }
    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setIdCompra($idcompra) {
        $this->idCompra = $idcompra;
    }
    public function setCoFecha($cofecha) {
        $this->cofecha = $cofecha;
    }
    public function setIdUsuario($idusuario) {
        $this->idUsuario = $idusuario;
    }
    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //Funcion set para ahorrar pasos
    public function set($idcompra, $cofecha, $idusuario) {
        $this->setIdCompra($idcompra);
        $this->setCoFecha($cofecha);
        $this->setIdUsuario($idusuario);
    }

    //Definimos la funcion cargar
    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra =" . $this->getIdCompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $fila = $base->Registro();
                $objUsuario = NULL;
                if ($fila['idusuario'] != null) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($fila['idusuario']);
                    $objUsuario->cargar(); 
                }
                $this->set($fila['idcompra'], $fila['cofecha'], $objUsuario);
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("compra->listar: " . $base->getError());
        }
        return $resp;
    }
    
    //Definimos la funcion insertar
    public function insertar() {
        
    }

    public function modificar(){

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
                $obj = new Compra();
                $obj->set($row['idcompra'], $row['cofecha'], $row['idusuario']);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("Compra->Listar: " . $base->getError());
        }
        return $arreglo;
    }
}