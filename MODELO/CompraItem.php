<?php
include_once __DIR__ . '/conector/BaseDatos.php';
Class CompraItem {
    private $idcompraitem;
    private $idproducto;
    private $idcompra;
    private $cicantidad;
    private $mensajeoperacion;

    public function __construct() {
        $this->idcompraitem = "";
        $this->idproducto = new Producto();
        $this->idcompra = new Compra();
        $this->cicantidad = "";
        $this->mensajeoperacion = "";
    }

    //Getters
    public function getIdCompraItem() {
        return $this->idcompraitem;
    }
    public function getIdProducto() {
        return $this->idproducto;
    }
    public function getIdCompra() {
        return $this->idcompra;
    }
    public function getCiCantidad() {
        return $this->cicantidad;
    }
    public function getMensajeOperacion() {
        return $this->mensajeoperacion;
    }

    //Setters
    public function setIdCompraItem($idcompraitem) {
        $this->idcompraitem = $idcompraitem;
    }
    public function setIdProducto($idproducto) {
        $this->idproducto = $idproducto;
    }
    public function setIdCompra($idcompra) {
        $this->idcompra = $idcompra;
    }
    public function setCiCantidad($cicantidad) {
        $this->cicantidad = $cicantidad;
    }
    public function setMensajeOperacion($mensajeoperacion) {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //Metodo set para ahorrar tiempo
    public function set($idcompraitem, $idproducto, $idcompra, $cicantidad) {
        $this->setIdCompraItem($idcompraitem);
        $this->setIdProducto($idproducto);
        $this->setIdCompra($idcompra);
        $this->setCiCantidad($cicantidad);
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
                if ($res > 0) {
                    $row = $base->Registro();
                    $objProducto = null;
                    if ($row['idproducto'] != null) {
                        $objProducto = new Producto();
                        $objProducto->setIdProducto($row['idproducto']);
                        $objProducto->cargar();
                    }
                    $objCompra = null;
                    if ($row['idcompra'] != null) {
                        $objCompra = new Compra();
                        $objCompra->setIdCompra($row['idcompra']);
                        $objCompra->cargar();
                    }
                    $this->set($row['idcompraitem'], $objProducto, $objCompra, $row['cicantidad']);
                    $resp = true;
                }
        } else {
            $this->setMensajeOperacion("CompraItem->Cargar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) VALUES ('{$this->getIdProducto()->getIdProducto()}', '{$this->getIdcompra()->getIdCompra()}', '1');";
        if ($base->Iniciar()) {
            if ($base = $base->Ejecutar($sql)) {
                $this->setIdCompraItem($base);
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->Insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->Insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraitem SET idcompraitem= '{$this->getIdCompraItem()}', idproducto = '{$this->getIdProducto()->getIdProducto()}', idcompra = '{$this->getIdCompra()->getIdCompra()}'
        , cicantidad = '{$this->getCiCantidad()}' WHERE idcompraitem = '{$this->getIdCompraItem()}'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->Modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->Modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompra = " . $this->getIdCompra();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->Eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->Eliminar: " . $base->getError());
        }
        return $resp;
    }
    public function eliminar2() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->Eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->Eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function listar($param = "") {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem ";
        if ($param != "") {
            $sql .= ' WHERE ' . $param;
        }

        $resp = $base->Ejecutar($sql);
        if ($resp > 0) {
            while ($row = $base->Registro()) {
                $obj = new CompraItem();
                $objProducto = null;

                if ($row['idproducto'] != null) {
                    $objProducto = new Producto();
                    $objProducto->setIdProducto($row['idproducto']);
                    $objProducto->cargar();
                }
                $objCompra = null;
                if ($row['idcompra'] != null) {
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->cargar();
                }

                $obj->set($row['idcompraitem'], $objProducto, $objCompra, $row['cicantidad']);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("CompraItem->Listar: " . $base->getError());
        }

        return $arreglo;
    }
}