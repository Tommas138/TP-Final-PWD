<?php
require_once __DIR__ . '/../../UTILS/funciones.php';
require_once "../../UTILS/MailSender.php";

$datos = data_submitted();
$exito = false;
$abmCompraEstado = new AbmCompraEstado();
$arrayCarrito = ['idcompra' => $datos['idcompraitem'], 'idcompraestadotipo' => 1];
$exito = $abmCompraEstado->alta($arrayCarrito);
$usuarioAbm = new AbmUsuario();
$usuario = $usuarioAbm->buscar($datos["idusuario"])[0];

if ($exito) {
    $message = 'Se envio el carrito correctamente';
    //header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    $compraItem = new CompraItem();   
    $compraItem->setIdCompra($datos['idcompraitem']); 
    $items = $compraItem->listar("idcompra = ". $datos['idcompraitem']);
    $i = 0;
    $gastoTotal = 0;
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
    }
    print_r($gastoTotal);
    // 2. Recopilas los datos para el mail
    $datosParaMail = [
        'id_pedido' => $datos["idcompraitem"], // El ID que acabas de generar
        'total' => $gastoTotal,
        'items' => $items
    ];

    // 3. Llamas al MailSender
    // (Asegúrate de incluir el archivo o usar el namespace correspondiente)
    //$notificador = new MailSender();
    //resultadoMail = $notificador->enviarConfirmacionCompra($usuario->getUsMail(), $usuario->getUsNombre(), $datosParaMail);
                
   // print_r($producto);
    $compraItem->eliminar();
    //exit;
} else {
    $message = 'Hubo un error al enviar su carrito';
    //header("Location: ../cliente/carrito.php?Message=" . urlencode($message));
    //exit;
}