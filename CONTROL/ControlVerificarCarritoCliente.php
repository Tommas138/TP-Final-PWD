<?php

Class ControlVerificarCarritoCliente {

    public function verificarCarrito($usuario) {
        $carritoHabilitado = null;
        $abmCompra = new AbmCompra();
        $listaCarritos = $abmCompra->buscar(["idusuario" => $usuario]);
        $arrayCompras = [];

        foreach ($listaCarritos as $carrito) {
            $compraEstadoCarrito = null;
            $idCarrito = $carrito->getIdCompra();
            $abmCompraEstado = new AbmCompraEstado();
            $compraEstadoCarrito = $abmCompraEstado->buscar(['idcompra' => $idCarrito]);

            if (!$compraEstadoCarrito) {
                $carritoHabilitado = $carrito;
            } else {
                array_pish($arrayCompras, $carrito);
            }
        }

        $arrayCarritos = ['carritoHabilitado' => $carritoHabilitado, 'arrayCompras' => $arrayCompras];
        return $arrayCarritos;
    }
}