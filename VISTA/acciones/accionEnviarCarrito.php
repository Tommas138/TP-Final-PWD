<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$exito = false;
$abmCompraEstado = new AbmCompraEstado();
$arrayCarrito = ['idcompra' => $datos['idcompraitem'], 'idcompraestadotipo' => 1];
$exito = $abmCompraEstado->alta($arrayCarrito);
$usuarioAbm = new AbmUsuario();
$usuario = $usuarioAbm->buscar($datos["idusuario"])[0];

if ($compraExitosa) {
    // 2. Recopilas los datos para el mail
    $datosParaMail = [
        'id_pedido' => $datos["idcompraitem"], // El ID que acabas de generar
        'total' => 5000,
        'items' => [
            ['nombre' => 'Zapatillas', 'precio' => 4000],
            ['nombre' => 'Medias', 'precio' => 1000]
        ]
    ];

    // 3. Llamas al MailSender
    // (Asegúrate de incluir el archivo o usar el namespace correspondiente)
    $notificador = new MailSender();
    $resultadoMail = $notificador->enviarConfirmacionCompra($usuarioMail, $usuario->getUsMail(), $datosParaMail);
    
    // 4. Redireccionas o muestras mensaje
}

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