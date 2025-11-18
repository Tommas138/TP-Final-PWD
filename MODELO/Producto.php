<?php
Class Producto {
    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;
    private $proprecio;
    private $mensajeOperacion;
    public function __construct(){
        $this->idproducto = null;
        $this->pronombre = "";
        $this->prodetalle = "";
        $this->procantstock = 0;
        $this->proprecio = 0.0;
        $this->mensajeOperacion = "";
    }

    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO producto (pronombre, prodetalle, procantstock, proprecio) VALUES ('" . addslashes($this->getPronombre()) . "','" . addslashes($this->getProdetalle()) . "','" . intval($this->getProcantstock()) . "','" . floatval($this->getProPrecio()). "')";
        if($base->Iniciar()) {
            if($elid = $base->Ejecutar($sql)) {
                $this->setIdProducto($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE producto SET pronombre='" . addslashes($this->getPronombre()) . "', prodetalle='" . addslashes($this->getProdetalle()) . "', procantstock='" . intval($this->getProcantstock()) . "', proprecio='" . floatval($this->getProPrecio()) . "' WHERE idproducto=" . intval($this->getIdProducto());
        if($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeOperacion("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto=" . $this->getIdProducto();
        if($base->Iniciar()) {
            if($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("producto->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto WHERE idproducto=" . $this->getIdProducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $fila = $base->Registro();
                $precio = isset($fila['proprecio']) ? $fila['proprecio'] : 0.0;
                $this->setIdProducto($fila['idproducto']);
                $this->setPronombre($fila['pronombre']);
                $this->setProdetalle($fila['prodetalle']);
                $this->setProcantstock($fila['procantstock']);
                $this->setProPrecio($precio);
                $resp = true;
            }
        } else {
            $this->setMensajeOperacion("producto->cargar: " . $base->getError());
        }
        return $resp;
    }

    public function set($idproducto, $pronombre, $prodetalle, $procantstock, $proprecio = 0.0) {
        $this->idproducto = $idproducto;
        $this->pronombre = $pronombre;
        $this->prodetalle = $prodetalle;
        $this->procantstock = $procantstock;
        $this->proprecio = $proprecio;
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

    public function getProPrecio() {
        return $this->proprecio;
    }
    public function setProPrecio($precio) {
        $this->proprecio = $precio;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function listar($param = "") {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($param != "") {
            $sql .= 'WHERE ' . $param;
        }
        $res = $base->Ejecutar($sql);
        if ($res > 0) {
            while ($row = $base->Registro()) {
                $obj = new Producto();
                // Set fields; handle missing columns safely
                $id = isset($row['idproducto']) ? $row['idproducto'] : null;
                $nombre = isset($row['pronombre']) ? $row['pronombre'] : '';
                $detalle = isset($row['prodetalle']) ? $row['prodetalle'] : '';
                $stock = isset($row['procantstock']) ? $row['procantstock'] : 0;
                $precio = isset($row['proprecio']) ? $row['proprecio'] : 0.0;
                $obj->set($id, $nombre, $detalle, $stock, $precio);
                $obj->setProPrecio($precio);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("Producto->Listar: " . $base->getError());
        }
        return $arreglo;
    }
}