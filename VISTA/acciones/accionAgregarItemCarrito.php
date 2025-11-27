<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();
$exito = false;
// Datos de sesion
$sesion = new Session();
$user = $sesion->getUsuario();
$idUser = $user->getIdUsuario();

$abmCompraItem = new AbmCompraItem(); 
$compraEstado = new AbmCompraEstado();
$existe = $compraEstado->check($idUser);
$datos['idusuario'] = $idUser;
$datos['existe'] = $existe;
$exito = $abmCompraItem->alta2($datos); 


if ($exito) {
    $message = 'Agregado correctamente al carrito';
    header("Location: ../listadoProductos.php?Message=" . urlencode($message));
   exit;
} else {
    $message = 'Hubo un error al agregar el articulo';
   header("Location: ../listadoProductos.php?Message=" . urlencode($message));
    exit;
}