<?php

Class ControlVerificarCarritoCliente2 {

    public function verificarCarrito2($usuario) {
        $carritoHabilitado = null;
        $abmCompra = new AbmCompra();
        $listaCarritos = $abmCompra->buscar(["idusuario" => $usuario]);
        $abmCompraEstado = new AbmCompraEstado();
        $listaCompraEstado = $abmCompra->buscar(["idusuario" => $usuario]);
        $arrayCompras = [];
        if ($listaCompraEstado) {
        $ultimo = end($listaCompraEstado);
        $idCompra = $ultimo->getIdCompra();
        }
       
        foreach ($listaCarritos as $carrito) {
            $compraEstadoCarrito = null;
            $idCarrito = $carrito->getIdCompra();
            $abmCompraEstado = new AbmCompraEstado();
            $compraEstadoCarrito = $abmCompraEstado->buscar(['idcompra' => $idCarrito]);
            if ($idCompra != $idCarrito) {
                
                $abmCompraEstado->crearNuevo(param: ['idusuario' => $usuario, 'idcompra' => $idCarrito]);
            }
            if ($compraEstadoCarrito) {
                $carritoHabilitado = $carrito;
            } else {
                array_push($arrayCompras, $carrito);
                $abmCompraEstado->crearNuevo(param: ['idusuario' => $usuario, 'idcompra' => $idCarrito]);
            }
        }
        
 

       //  $abmCompraEstado->crearNuevo(['idusuario' => $usuario, 'idcompra' => $idCarrito]);
        $arrayCarritos = ['carritoHabilitado' => $carritoHabilitado, 'arrayCompras' => $arrayCompras];
        return $arrayCarritos;
    }
}