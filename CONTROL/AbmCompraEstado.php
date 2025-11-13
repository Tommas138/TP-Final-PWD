<?php

Class AbmCompraEstado {

    private function cargarObjeto($param) {
        $obj = null;

        if (array_key_exists('idcompra', $param)) {
            $objProducto = new Compra();
            $objProducto->setIdCompra($param['idcompra']);
            $objProducto->cargar();
            
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($parma['idcompraestadotipo']);
            $objCompraEstadoTipo->cargar();

            $obj = new CompraEstado();
            $obj->set('', $objProducto, $objCompraEstadoTipo, '', '');
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;

        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->set($param['idcompraestado'], null, null, null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;

        if (isset($param['idcompraestado'])) {
            $resp = true;
        }

        return $resp;
    }

    public function alta($param) {
        $resp = false;
        $abmCompraItem = new AbmCompraItem();
        $abmProducto = new AbmProducto();

        $listadoitems = $abmCompraItem->buscar(['idcompra' => $param['idcompra']]);
        print_r($listadoitems);
        $stock = true;
        //busco stock
        foreach ($listadoItems as $item) {
            $respStock = $abmProducto->chequearStock($item);
            if (!$respStock) {
                $stock = false;
            }
        }
        //si hay stock envio carrito
        if ($stock) {
            $objCompraEstado = $this->cargarObjeto($param);
            if ($objCompraEstado != null && $objCompraEstado->insertar()) {
                $resp = true;
            }
        }
        // si carga carrito modifico stock y cuantas veces se compro el producto
        if ($resp) {
            foreach ($listadoItems as $item) {
                $objProducto = new Producto();
                $producto = $objProducto->listar("idproducto = '" . $item->getIdProducto()->getIdProducto() . "'");
                $stockActual = $prodcuto[0]->getProCantStock();
                $stockActualizado = $stockActual - $item->getCiCantidad();
                $producto[0]->setProStock($stockActualizado);
                $vecesCompradoActual = $producto[0]->getProVecesComprado();
                $vecesCompradoAct = $vecesCompradoActual + $item->getCiCantidad();
                $producto[0]->setProVecesComprado($vecesCompradoAct);
                $respModificar = $producto[0]->modificar();
                if (!$respModificar) {
                    $exito = false;
                }
            }
        }
    return $resp;
    }

    public function modificacion($param) {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            //busco estadoCompra actual
            $arreglo = ["idcompra" => $param['idcompraestado']];
            $arrayBusq = ["idcompra" => $arreglo['idcompra']];
            $objCompraEstadoBusq = $this->buscar($arrayBusq);
            //busco estadoTipo de 'aceptada'
            $abmEstadoTipo = new AbmCompraEstadoTipo;
            $objCompraEstadoTipo = $abmEstadoTipo->buscar(['idcompraestadotipo' => 2]);
            // set compraEstadoTipo 'aceptada'
            $objCompraEstadoBusq[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
            //Si la compra es not null y la fecha  de fin es igual a 0000-00-00 00:00:00 entonces mod el estadoTipo
            if ($objCompraEstadoBusq != null && $objCompraEstadoBusq[0]->getCeFechaFin() == "0000-00-00 00:00:00") {
                if ($objCompraEstadoBusq[0]->modificar()) {
                    $resp = true;
                }
            }
        }
    return $resp;
    }

    public function enviarCompra($param) {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            //busco estadoCompra actual
            $arreglo = ["idcompra" => $param['idcompraestado']];
            $arrayBusq = ["idcompra" => $arreglo['idcompra']];
            $objCompraEstadoBusq = $this->buscar($arrayBusq);
            //busco estadoTipo 'aceptada'
            $abmEstadoTipo = new AbmCompraEstadoTipo;
            $objCompraEstadoTipo = $abmEstadoTipo->buscar(['idcompraestadotipo' => 3]);
            //set compraEstadoTipo 'aceptada'
            $objCompraEstadoBusq[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
            //Si la compra es not null y la fecha  de fin es igual a 0000-00-00 00:00:00 entonces mod el estadoTipo
            if ($objCompraEstadoBusq != null && $objCompraEstadoBusq[0]->getCeFechaFin() == "0000-00-00 00:00:00") {
               $objCompraEstadoBusq[0]->setCeFechaFin(date("Y-m-d H:i:s"));
                if ($objCompraEstadoBusq[0]->modificar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    public function finCompra($param) {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjetoConClave($param);
            $listaCompraEstado = $objCompraEstado->listar("idcompraestado= '" . $param['idcompraestado'] . "'");
            print_r($listaCompraEstado);
            if (count($listaCompraEstado) > 0) {
                $estadoCompra = $listaCompraEstado[0]->getCeFechaFin();
                if ($estadoCompra == '0000-00-00 00:00:00') {
                    $abmEstadoTipo = new AbmCompraEstadoTipo;
                    $objCompraEstadoTipo = $abmEstadoTipo->buscar(['idcompraestadotipo' => 4]);
                    //set compraEstadoTipo 'cancelada'
                    $listaCompraEstado[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
                    if ($listaCompraEstado[0]->modificar()) {
                        $listaCompraEstado[0]->estado(date("Y-m-d H:i:s"));
                        $resp = true;
                    }
                }
            }

            if ($resp) {
                $abmCompraItem = new AbmCompraItem();
                $listadoItems = $abmCompraItem->buscar(['idcompra' => $param['idcompraestado']]);
                foreach ($listadoItems as $item) {
                    $abmProducto = new AbmProducto();
                    $objProducto = $item->getIdProducto();
                    $producto = $abmProducto->buscar(['idproducto' => $objProducto->getIdProducto()]);
                    $stockActual = $producto[0]->getProCantStock();
                    $stockAct = $stockActual + $item->getCiCantidad();
                    $producto[0]->setProStock($stockAct);
                    $vecesCompradoActual = $producto[0]->getProVecesComprado();
                    $vecesCompradoAct = $vecesCompradoActual - $item->getCiCantidad();
                    $producto[0]->setProVecesComprado($vecesCompradoAct);
                    $producto[0]->modificar();
                }
            }
        }
        return $resp;
    }


    public function buscar($param) {
        $where = " true ";

        if ($param <> NULL) {
            if  (isset($param['idcompraestado']))
                $where .= " AND idcompraestado = " . $param['idcompraestado'];
            if (isset($param['idcompra']))
                $where .= " AND idcompra = " . $param['idcompra'];
            if (isset($param['idcompraestadotipo']))
                $where .= " AND idcompraestadotipo = '" . $param['idcompraestadotipo'] . "'";
            if (isset($param['cefechaini']))
                $where .= " AND cefechaini = '" . $param['cefechaini']. "'";
            if (isset($param['cefechafin']))
                $where .= " AND cefechafin = '" . $param['cefechafin'] . "'";
        }
        $arreglo = CompraEstado::listar($where);

        return $arreglo;
    }
}