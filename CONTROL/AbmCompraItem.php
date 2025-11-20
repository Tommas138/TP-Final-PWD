<?php

include_once __DIR__ . '/../MODELO/CompraItem.php';
include_once __DIR__ . '/../MODELO/Producto.php';
include_once __DIR__ . '/../MODELO/Compra.php';
include_once __DIR__ . '/../CONTROL/ControlVerificarCarritoCliente.php';
include_once __DIR__ . '/../CONTROL/AbmCompra.php';
include_once __DIR__ . '/../CONTROL/AbmProducto.php';

Class AbmCompraItem {

    private function cargarObjeto($param) {
    $obj = null;
    if (array_key_exists('idproducto', $param) && array_key_exists('idcompra', $param)) {
        $objProducto = new Producto();
        $objProducto->setIdProducto($param['idproducto']);
        $objProducto->cargar();

        $objCompra = new Compra();
        $objCompra->setIdCompra($param['idcompra']);
        $objCompra->cargar();

        $obj = new CompraItem();
        $obj->set($param['idcompraitem'], $objProducto, $objCompra, $param['cicantidad']);
    }

    return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idcompraitem'])) {
            $obj = new CompraItem();
            $obj->set($param['idcompraitem'], null, null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp =false;
        if (isset($param['idcompraitem'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param) {
        $resp = false;
        // traigo carritos del us
        $controlVerificarCarrito = new ControlVerificarCarritoCliente();
        $arrayCarritos = $controlVerificarCarrito->verificarCarrito($param['idusuario']);
        // carrito habilitado
        $carrito = $arrayCarritos['carritoHabilitado'];
        // si no existe creo nuevo carrito
        if ($carrito == null || !($carrito instanceof Compra)) {
            $abmCarrito = new AbmCompra();
            $array = ['idusuario' => $param['idusuario']];
            // alta de carrito
            $altaCarrito = $abmCarrito->alta($array);
            if ($altaCarrito) {
                //traigo carrito
                $arrayCarritos = $controlVerificarCarrito->verificarCarrito($param['idusuario']);
                $carrito = $arrayCarritos['carritoHabilitado'];
            }
        }
        // validar que carrito existe antes de continuar
        if ($carrito == null) {
            error_log("AbmCompraItem::alta - No se pudo crear/obtener carrito para usuario " . $param['idusuario']);
            return $resp;
        }
        // saco id carrito actual
        $idCarrito = $carrito->getIdCompra();
        //establezco datos de interes, idProducto e idCarrito
        $arrayCargaItem = ['idproducto' => $param['idproducto'], 'idcompra' => $idCarrito];
        $cargado = false;
        // lista de items cargados en el carrito
        $arrayItemsCarrito = $this->buscar(['idcompra' => $carrito->getIdCompra()]);
        //verifico que el item actual no este cargado
        foreach ($arrayItemsCarrito as $itemCarrito) {
            if ($itemCarrito->getIdProducto()->getIdProducto() == $param['idproducto']) {
                $cargado = true;
            }
        }
        // si no esta cargado se inserta en la BD
        if (!$cargado) {
            //inserto item
            $objCompraItem = $this->cargarObjeto($arrayCargaItem);
            if ($objCompraItem != null && $objCompraItem->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjetoConClave($param);
            if ($objCompraItem != null && $objCompraItem->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjeto($param);
            if ($objCompraItem != null && $objCompraItem->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function sumarItem($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjetoConClave($param);
            $objCompraItem = $this->buscar(['idcompraitem' => $param['idcompraitem']]);
            if ($objCompraItem[0] != null) {
                $idProducto = $objCompraItem[0]->getIdProducto()->getIdProducto();
                $abmProducto = new AbmProducto();
                $objProducto = $abmProducto->buscar(['idproducto' => $idProducto]);
                $stockActual = $objProducto[0]->getProCantStock();
                $cantItems = $objCompraItem[0]->getCiCantidad();
                if ($stockActual > $cantItems) {
                    $objCompraItem[0]->setCiCantidad($cantItems + 1);
                    if ($objCompraItem[0]->modificar()) {
                        $resp = true;
                    }
                }
            }
        }
        return $resp;
    }

    public function restarItem($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraItem = $this->cargarObjetoConClave($param);
            $objCompraItem = $this->buscar(['idcompraitem' => $param['idcompraitem']]);
            if ($objCompraItem[0] != null) {
                $cantItems = $objCompraItem[0]->getCiCantidad();
                if ($cantItems > 1) {
                    $objCompraItem[0]->setCiCantidad($cantItems - 1);
                    if ($objCompraItem[0]->modificar()) {
                        $resp = true;
                    }
                }
            }
        }
        return $resp;
    }

    public function buscar($param) {
        
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idcompraitem']))
                $where .= " AND idcompraitem = " . $param['idcompraitem'];
            if (isset($param['idproducto'])) 
                $where .= " AND idproducto = " . $param['idproducto'];
            if (isset($param['idcompra']))
                $where .= " AND idcompra = '" . $param['idcompra'] . "'";
            if (isset($param['cicantidad']))
                $where .= " AND cicantidad = '" . $param['cicantidad'] . "'";
        }

        $compraItem = new CompraItem();
        $idcompraitem = isset($param['idcompra']) ? $param['idcompra'] : null;
        $compraItem->set( null, null,$idcompraitem, null);
        $arreglo = $compraItem->listar($where);
        
        return $arreglo;
    }
}