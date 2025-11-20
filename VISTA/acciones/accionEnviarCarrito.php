<?php
require_once __DIR__ . '/../../UTILS/funciones.php';
require_once "../../UTILS/MailSender.php";

$datos = data_submitted();
$exito = false;
$abmCompraEstado = new AbmCompraEstado();
$arrayCarrito = ['idcompra' => $datos['idcompraitem'], 'idcompraestadotipo' => 1];
$exito = $abmCompraEstado->alta($arrayCarrito);
$usuarioAbm = new AbmUsuario();
$usuario = $usuarioAbm->buscar($datos)[0];
print_r($usuario);
if ($exito) {
    $message = 'Se envio el carrito correctamente';
    $compraItem = new CompraItem();   
    $compraItem->setIdCompra($datos['idcompraitem']); 
    $items = $compraItem->listar("idcompra = ". $datos['idcompraitem']);
    $i = 0;
    $gastoTotal = 0;
    $productos = array();
    foreach ($items as $item) {
        $objProd = $item->getIdProducto();
        $stock = $item->getCiCantidad();
        $prod = New Producto();
        $prod->setIdProducto( $objProd->getIdProducto());
        $prod->cargar();
        $nuevoStock = $prod->getProcantstock() - $stock;
        $prod->setProcantstock($nuevoStock);
        $prod->modificar();
        $gastoTotal += $prod->getProPrecio();
        array_push($productos,$prod);
    }
    print_r($gastoTotal);
    // 2. Recopilas los datos para el mail
    $datosParaMail = [
        'id_pedido' => $datos["idcompraitem"], // El ID que acabas de generar
        'total' => $gastoTotal,
        'items' => $productos
    ];

    $notificador = new MailSender();
    $resultadoMail = $notificador->enviarConfirmacionCompra($usuario->getUsMail(), $usuario->getUsNombre(), $datosParaMail);
                
    $compraItem->eliminar();
    header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    exit;
} else {
    $message = 'Hubo un error al enviar su carrito';
    header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    exit;
}