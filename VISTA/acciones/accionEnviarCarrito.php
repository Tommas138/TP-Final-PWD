<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$exito = false;
$abmCompraEstado = new AbmCompraEstado();

$arrayCarrito = ['idcompra' => $datos['idcompraitem'], 'idcompraestadotipo' => 1];
$exito = $abmCompraEstado->alta($arrayCarrito);

if ($exito) {
    $message = 'Se envio el carrito correctamente';
    header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    $compraItem = new CompraItem();   
    $compraItem->setIdCompra($datos['idcompraitem']); 
    $producto = $compraItem->listar("idcompra = ". $datos['idcompraitem']);
    $i = 0;
    foreach ($producto as $prod) {
        $objProd = $prod->getIdProducto();
       $stock = $prod->getCiCantidad();
        $prod = New Producto();
        $prod->setIdProducto( $objProd->getIdProducto());
        $prod->cargar();
        $nuevoStock = $prod->getProcantstock() - $stock;
        $prod->setProcantstock($nuevoStock);
        $prod->modificar();
    }
                
   // print_r($producto);
    $compraItem->eliminar();
    exit;
} else {
    $message = 'Hubo un error al enviar su carrito';
    header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    exit;
}