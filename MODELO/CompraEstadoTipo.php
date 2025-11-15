<?php

Class CompraEstadoTipo {
    private $idcompraestadotipo;
    private $cetdescripcion;
    private $cetdetalle;
    private $mensajeoperacion;

    public function __construct() {
        $this->idcompraestadotipo = "";;
        $this->cetdescripcion = "";
        $this->cetdetalle = "";
        $this->mensajeoperacion = "";
    }

    //Getters
    public function getIdCompraEstadoTipo() {
        return $this->idcompraestadotipo;
    }
    public function getCetDescripcion() {
        return $this->cetdescripcion;
    }
    public function getCetDetalle() {
        return $this->cetdetalle;
    }
    public function getMensajeOperacion() {
        return $this->mensajeoperacion;
    }

    //Setters
    public function setIdCompraEstadoTipo($idcompraestadotipo) {
        $this->idcompraestadotipo = $idcompraestadotipo;
    }
    public function setCetDescripcion($cetdescripcion) {
        $this->cetdescripcion = $cetdescripcion;
    }
    public function setCetDetalle($cetdetalle) {
        $this->cetdetalle = $cetdetalle;
    }
    public function setMensajeOperacion($mensajeoperacion) {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //set para ahorrar tiempo xd
    public function set($idcompraestadotipo, $cetdescripcion, $cetdetalle) {
        $this->setIdCompraEstadoTipo($idcompraestadotipo);
        $this->setCetDescripcion($cetdescripcion);
        $this->setCetDetalle($cetdetalle);
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = " . $this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $row = $base->Registro();
                $this->set($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->Cargar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestadotipo (cetdescripcion, cetdetalle) VALUES ('" . $this->getCetDescripcion() . "', '" . $this->getCetDetalle() . "');";

        if ($base->Iniciar()) {
            if ($base= $base->Ejecutar($sql)) {
                $this->setIdCompraEstadoTipo($base);
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->Insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->Insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestadotipo SET idcompraestadotipo = '" . $this->getIdCompraEstadoTipo() . "', cetdescripcion = '" . $this->getCetDescripcion() .
         "', cetdetalle = '" . $this->getCetDetalle() . "' WHERE idcompraestadotipo = '" . $this->getIdCompraEstadoTipo() . "'";

         if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->Modificar: " . $base->getError());
            }
         } else {
            $this->setMensajeOperacion("CompraEstadoTipo->Modificar: " . $base->getError());
         }
         return $resp;
    }

    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo = " . $this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->Eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->Eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function listar($param = "") {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo ";
        if ($param != "") {
            $sql .= 'WHERE ' . $param;
        }
        $res = $base->Ejecutar($sql);
        if ($res > 0) {
            while ($row = $base->Registro()) {
                $obj = new CompraEstadoTipo();
                $obj->set($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->Listar: " . $base->getError());
        }
        return $arreglo;
    }
}