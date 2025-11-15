<?php 

Class CompraEstado {
    private $idcompraestado;
    private $idcompra;
    private $idcompraestadotipo;
    private $cefechaini;
    private $cefechafin;
    private $mensajeOperacion;

    public function __construct() {
        $this->idcompraestado = "";
        $this->idcompra = "";
        $this->idcompraestadotipo = "";
        $this->cefechaini = "";
        $this->cefechafin = "";
        $this->mensajeOperacion = "";
    } 

    //getters
    public function getIdCompraEstado() {
        return $this->idcompraestado;
    }
    public function getIdCompra() {
        return $this->idcompra;
    }
    public function getIdCompraEstadoTipo() {
        return $this->idcompraestadotipo;
    }
    public function getCeFechaIni() {
        return $this->cefechaini;
    }
    public function getCeFechaFin() {
        return $this->cefechafin;
    }
    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    //setters
    public function setIdCompraEstado($idcompraestado) {
        $this->idcompraestado = $idcompraestado;
    }
    public function setIdCompra($idcompra) {
        $this->idcompra = $idcompra;
    }
    public function setIdCompraEstadoTipo($idcompraestadotipo) {
        $this->idcompraestadotipo = $idcompraestadotipo;
    }
    public function setCeFechaIni($cefechaini) {
        $this->cefechaini = $cefechaini;
    }
    public function setCeFechaFin($cefechafin) {
        $this->cefechafin = $cefechafin;
    }
    public function setMensajeOperacion($mensaje) {
        $this->mensajeOperacion = $mensaje;
    }

    //funcion set para ahorrar tiempo xd
    public function set($idcompraestado, $idcompra, $idcompraestadotipo, $cefechaini, $cefechafin) {
        $this->setIdCompraEstado($idcompraestado);
        $this->setIdCompra($idcompra);
        $this->setIdCompraEstadoTipo($idcompraestadotipo);
        $this->setCeFechaIni($cefechaini);
        $this->setCeFechaFin($cefechafin);
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idcompraestado = " . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $row = $base->Registro();
                $objCompra = null;
                if ($row['idcompra'] != null) {
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->cargar();
                }
                $objCompraEstadoTipo = null;
                if ($row['idcompraestadotipo'] != null) {
                    $objCompraEstadoTipo = new CompraEstadoTipo;
                    $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                    $objCompraEstadoTipo->cargar();
                }

                $this->set(
                    $row['idcompraestado'],
                    $objCompra,
                    $objCompraEstadoTipo,
                    $row['cefechaini'],
                    $row['cefechafin']
                );
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->Listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $objCompra = new Compra();
        $objCompra->setIdCompra($this->getIdCompra());
        $objCompra->cargar();
        $objCompraEstadoTipo = new CompraEstadoTipo();
        $objCompraEstadoTipo->setIdCompraEstadoTipo($this->getIdCompraEstadoTipo());
        $objCompraEstadoTipo->cargar();
        $sql = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechafin) VALUES (" . $objCompra->getIdCompra() . 
        ", " . $objCompraEstadoTipo->getIdCompraEstadoTipo() . ", '0000-00-00 00:00:00')";

        if ($base->Iniciar()) {
            if ($res = $base->Ejecutar($sql)) {
                $this->setIdCompraEstado($res);
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstado->Insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->Insertar: " . $base->getError());
        }
        return $resp;
        }

        public function modificar() {
            $resp = false;
            $base = new BaseDatos();
            $sql = "UPDATE compraestado SET idcompra= '{$this->getIdCompra()}', idcompraestadotipo= '{$this->getIdCompraEstadoTipo()->getIdCompraEstadoTipo()}',
            cefechaini= '{$this->getCeFechaIni()}', cefechafin= '{$this->getCeFechaFin()}' WHERE idcompraestado= '{$this->getIdCompraEstado()}'";

            if ($base->Iniciar()) {
                if ($base->Ejecutar($sql)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion("CompraEstado->Modificar: " . $base->getError());
                } 
            } else {
                $this->setMensajeOperacion("CompraEstado->Modificar: " . $base->getError());
            }
            return $resp;
        }

        public function eliminar() {
            $resp = false;
            $base = new BaseDatos();
            $sql = "DELETE FROM compraestado WHERE idcompraestado = " . $this->getIdCompraEstado();
            
            if ($base->Iniciar()) {
                if ($base->Ejecutar($sql)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion("CompraEstado->Eliminar: " . $base->getError());
                }
            } else {
                $this->setMensajeOperacion("CompraEstado->Eliminar: " . $base->getError());
            }
            return $resp;
        }

        public function listar($parametro = "") {
            $arreglo = array();
            $base = new BaseDatos();
            $sql = "SELECT * FROM compraestado ";
            if ($parametro != "") {
                $sql .= 'WHERE ' . $parametro;
            }

            $resp = $base->Ejecutar($sql);
            if ($resp > 0 ) {

                while ($row = $base->Registro()) {
                    $obj = new CompraEstado();
                    $objCompra = null;
                    if ($row['idcompra'] != null) {
                        $objCompra = new Compra();
                        $objCompra->setIdCompra($row['idcompra']);
                        $objCompra->cargar();
                    }
                    $objCompraEstadoTipo = null;
                    if ($row['idcompraestadotipo'] != null) {
                        $objCompraEstadoTipo = new CompraEstadoTipo();
                        $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                        $objCompraEstadoTipo->cargar();
                    }

                    $obj->set($row['idcompraestado'], $objCompra, $objCompraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obj);
                }
            } else {
                $this->setMensajeOperacion("CompraEstado->Listar: " . $base->getError());
            }
            return $arreglo;
        }

        public function estado($param = "") {
            $resp = false;
            $base = new BaseDatos();
            $sql = "UPDATE compraestado SET cefechafin = '" . $param . "' WHERE idcompraestado={$this->getIdCompraEstado()}";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($sql)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion("CompraEstado->Estado: " . $base->getError());
                }
            } else {
                    $this->setMensajeOperacion("CompraEstado->Estado: " . $base->getError());
            }
             return $resp;
        }
        
    }
