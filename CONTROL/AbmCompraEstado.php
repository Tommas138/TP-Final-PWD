<?php

include_once __DIR__ . '/../MODELO/CompraEstado.php';
include_once __DIR__ . '/../MODELO/Compra.php';
include_once __DIR__ . '/../MODELO/CompraItem.php';
include_once __DIR__ . '/../MODELO/CompraEstadoTipo.php';

Class AbmCompraEstado {

    private function cargarObjeto($param) {
        $obj = null;

        if (array_key_exists('idcompra', $param)) {
            $objProducto = new Compra();
            $objProducto->setIdCompra($param['idcompra']);
            $objProducto->cargar();
            
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo(1);
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

    public function crearNuevo($param) {
        $compra = new AbmCompra();
        $user = $compra->buscar(['idusuario' => $param['idusuario']]);
        $ultimo = end($user);
        $idCompra = $ultimo->getIdCompra();
        $existe = $this->buscar(['idcompra' => $idCompra]);
        if (!$existe) {
        $this->alta(['idcompra' => $idCompra]);
        }
    }
     public function alta($param)
    {
        $resp = false;
        $objcompraestado = $this->cargarObjeto($param);
        if ($objcompraestado != null and $objcompraestado->insertar()) {
            $resp = true;
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
        // NOTA: En tu vista administrarCompras.php, el input hidden envía el idCompra 
        // bajo el nombre 'idcompraestado'. Por eso usamos ese parametro para buscar.
        $idCompra = $param['idcompraestado'];

        // 1. Buscamos todos los estados relacionados a esa compra
        $objCompraEstadoBusq = $this->buscar(['idcompra' => $idCompra]);

        // 2. Buscamos el objeto del Tipo de Estado "Enviada" (ID 3)
        $abmEstadoTipo = new AbmCompraEstadoTipo;
        $objCompraEstadoTipo = $abmEstadoTipo->buscar(['idcompraestadotipo' => 3]);

        // 3. Iteramos para encontrar el estado que está ACTIVO (fecha fin nula/ceros)
        foreach ($objCompraEstadoBusq as $estado) {
            // Verificamos que sea el estado activo actual
            if ($estado->getCeFechaFin() == "0000-00-00 00:00:00") {
                
                // Asignamos el nuevo tipo (3 - Enviada)
                $estado->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
                
                // IMPORTANTE: No seteamos fecha fin aquí (setCeFechaFin), 
                // porque el envío es un proceso activo.
                
                if ($estado->modificar()) {
                    $resp = true;
                }
                // Salimos del bucle una vez modificado el activo
                break;
            }
        }
    }
    return $resp;
}
public function modificarEstadoCarrito($param) {
        $resp = false;
        $idCompra = ['idcompra' => $param['idcompra']];
            
            $objCompraEstadoBusq = $this->buscar($idCompra);
            $compraEstadoTipo = new AbmCompraEstadoTipo();
            $objCompraEstadoTipo = $compraEstadoTipo->buscar(['idcompraestadotipo' => 2]);
            //print_r($objCompraEstadoTipo);
            $objCompraEstadoBusq[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
            $objCompraEstadoBusq[0]->modificar();

            

    }
    
public function modificarEstado($param) {
        $resp = false;
        $idCompra = ['idcompra' => $param['idcompra']];
            
            $objCompraEstadoBusq = $this->buscar($idCompra);
            $compraEstadoTipo = new AbmCompraEstadoTipo();
            $objCompraEstadoTipo = $compraEstadoTipo->buscar(['idcompraestadotipo' => 2]);
            //print_r($objCompraEstadoTipo);
            $objCompraEstadoBusq[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
            $objCompraEstadoBusq[0]->modificar();

            

    }
    public function finCompra($param) {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjetoConClave($param);
            $listaCompraEstado = $objCompraEstado->listar("idcompraestado= '" . $param['idcompraestado'] . "'");
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
                    $stockActual = $producto[0]->getProcantstock();
                    $stockAct = $stockActual + $item->getCiCantidad();
                    $producto[0]->setProcantstock($stockAct);
                    $producto[0]->modificar();
                }
            }
        }
        return $resp;
    }

 public function aceptarCompra($param)
    {
        $resp = false;

        
            $arrayBusqueda = ["idcompra" => $param['idcompra']];
            $objCompraEstadoBusqueda = $this->buscar($arrayBusqueda);
            $objCompra = $this->cargarObjeto($arrayBusqueda);
            print_r($objCompra);
            //$objCompra->setIdCompraEstado(3);
            //echo $objCompra->getIdCompraEstado();
            //print_r($idCompra);
          //  $compra[0]->setIdCompraEstadoTipo(3);

            if ($objCompraEstadoBusqueda != null and $objCompraEstadoBusqueda[0]->getCeFechaFin() == "0000-00-00 00:00:00") {
                if ($objCompraEstadoBusqueda[0]->modificar()) {
                    $resp = true;
                }
            }
        

        return $resp;
    }
    public function buscar($param) {
        $where = " true ";

        //print_r($param);
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
        $objCompraEstado = new CompraEstado();
        $arreglo = $objCompraEstado->listar($where);

        return $arreglo;
    }
}