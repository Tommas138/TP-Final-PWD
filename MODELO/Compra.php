<?php
class Compra {
    //Definimos los atributos
    private $idCompra;
    private $cofecha;
    private $idUsuario;
    private $mensajeOperacion;

    //Definimos la funcion __construct
    public function __construct() {
        $this->idcompra = "";
        $this->cofecha = "";
        $this->idusuario = new Usuario();
        $this->mensajeoperacion = "";
    }

    //Definimos las funciones para los gets y sets
    public function getIdCompra () {
        return $this->idcompra;
    }
    public function getCoFecha () {
        return $this->cofecha;
    }
    public function getIdUsuario () {
        return $this->idusuario;
    }
    public function getMensajeOperacion () {
        return $this->mensajeoperacion;
    }

    public function setIdCompra($idcompra) {
        $this->idcompra = $idcompra;
    }
    public function setCoFecha($cofecha) {
        $this->cofecha = $cofecha;
    }
    public function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    public function setMensajeOperacion($mensajeoperacion) {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //Funcion set para ahorrar pasos
    public function set($idcompra, $cofecha, $idusuario) {
        $this->setIdCompra($idcompra);
        $this->setCoFeha($cofecha);
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
                if (fila['idusuario'] != null) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($fila['idusuario']);
                    $objUsuario->cargar(); 
                }
                $this->setear($fila['idcompra'], $fila['cofecha'], $objUsuario);
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
}