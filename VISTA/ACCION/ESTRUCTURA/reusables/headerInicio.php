<?php
include_once __DIR__ . '../../../../../UTILS/funciones.php';

$cantidadItemsCarrito = 0;
$sesion = new Session();

if ($sesion->activa()) {

    // $user = $sesion->getUsuario();
    // $name = $user->getUsNombre();
    // $idUser = $user->getIdUsuario();

    $user = $sesion->getUsuario();
    $name = $sesion->getUsNombre();
    $idUser = $sesion->getIdUsuario();
}
$enlace = "";
?>
<nav class="navbar navbar-expand-custom navbar-mainbg">

    <a class="navbar-brand navbar-logo navbar-button " href="../../VISTA/home/index.php">Dunder Mifflin Store</a>
    <a class="navbar-brand navbar-logo navbar-button" href="../../VISTA/CLIENTE/listadoProductos.php">Productos</a>
   
   <?php if (!$sesion->activa()) { ?>
    <div class="bg-primary text-white p-2 rounded">
        <form action="../../index.php">
            <button type="submit" class="btn btn-sm">
                Iniciar Sesion
            </button>
        </form>
  <?php  } else {
    ?>
        <div class="bg-primary text-white p-2 rounded">
        <form action="../../VISTA/acciones/cerrarSesion.php">
            <button type="submit" class="btn btn-sm">
                Cerrar Sesion
            </button>
        </form>
        <?php } ?>


</nav>