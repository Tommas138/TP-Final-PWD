<?php

Class AbmProducto {

    private function cargarObjeto($param) {
        if (array_key_exists('idproducto', $param) && array_key_exists('proprecio', $param) && array_key_exists('prodescuento', $param)
            && array_key_exists('pronombre', $param) && array_key_exists('prodetalle', $param) && array_key_exists('procantstock', $param)) {
        $obj = new Producto();
        $obj->set(
            $param['idproducto'],
            $param["pronombre"],
            $param['prodetalle'],
            $param['procantstock'],
        );
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idproducto'])) {
            $obj = new Producto();
            $obj->set($param['idproducto'], null, null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['idproducto'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param) {
        $resp = false;
        $existe = false;
        $datosBusqueda['idproducto'] = $param['idproducto'];
        $listaProductos = $this->buscar($param);
        if (isset($listaProductos[0])) {
            $existe = true;
        }
        if (!$existe) {
            $objProducto = $this->cargarObjeto($param);
            if ($objProducto != null && $objProducto->insertar()) {
                $resp = true;
            }
            $controlCargaImagen = new controlCargaImagenes();
            $controlCargaImagen->cargarImagen($param['files'], $param['idproducto']);
        }
        return $resp;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objProducto = $this->cargarObjetoConClave($param);
            if ($objProducto != null && $objProducto->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;
        print_r($param);
        if ($this->seteadosCamposClaves($param)) {
            $listaProductos = $this->buscar(['idproducto'=> $param['idproducto']]);
            if ($listaProductos != null) {
                $objProducto = $this->cargarObjeto($param);
                if ($objProducto->modificar()) {
                    $resp = true;
                    $controlCargaImagen = new controlCargaImagenes();
                    $nombreImagen = $param['files']['imagen']['name'];
                    if ($nombreImagen != "") {
                        $controlCargaImagen->eliminarImagen($param['idproducto']);
                        $controlCargaImagen->cargarImagen($param['files'], $param['idproducto']);
                    }
                }
            }
        }
        return $resp;
    }


    public function chequearStock($param) {
        $resp = false;
        $idProducto = $param->getIdProducto()->getIdProducto();
        $objProducto = $this->cargarObjetoConClave(["idproducto" => $idProducto]);
        $listaProductos = $objProducto->listar("idproducto = '" .$idProducto . "'");
        if (count($listaProductos) > 0) {
            $stock = $listaProductos[0]->getProCantStock();
            if ($stock >= $param->getCiCantidad()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idproducto']))
                $where .= " AND idproducto = '" . $param['idproducto'] . "'";
            if (isset($param['pronombre']))
                $where .= " AND pronombre = '" . $param['pronombre'] . "'";
            if (isset($param['prodetalle']))
                $where .= " AND prodetalle = '" . $param['prodetalle'] . "'";
            if (isset($param['procantstock']))
                $where .= " AND procantstock = '" . $param['procantstock'] . "'";
        }
        $objProd = new Producto();
        $arreglo = $objProd->listar($where);
        return $arreglo;
    } 
    
}
