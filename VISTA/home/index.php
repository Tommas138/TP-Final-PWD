<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$titulo = 'Dunder Mifflin Store';

include_once '../ACCION/ESTRUCTURA/reusables/header.php';
$sesion = new Session();
$abmProductos = new AbmProducto();
$listaProductos = $abmProductos->buscar(null);
shuffle($listaProductos);

?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Tienda de suplementos</h1>
            <p class="lead fw-normal text-white-50 mb-0">
            <h4><i class="fas fa-car-crash"></i></h4>
            </p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-2">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            if (count($listaProductos) > 0) {
                $max = min(count($listaProductos), 8);
                for ($cont_prod = 0; $cont_prod < $max; $cont_prod++) {
                    $producto = $listaProductos[$cont_prod];
                    $idHash = md5($producto->getIdProducto());
                    $idHashImg = strtolower($idHash);

                                 ?>

                                <?php
                                    $imgRel = '../../uploads/img/' . $idHashImg . '.jpeg';
                                    $imgAbs = __DIR__ . '/../../uploads/img/' . $idHashImg . '.jpeg';
                                    if (!file_exists($imgAbs)) {
                                        // fallback to generic existing image
                                        $imgRel = '../../uploads/img/image.jpeg';
                                    }
                                ?>
                                <img class='card-img-top' src='<?php echo $imgRel; ?>' alt='Imagen de un suplemento' />

                                <div class='card-body p-4'>
                                    <div class='text-center'>
                                        <h5 class='fw-bolder'><?php echo $producto->getProNombre() ?></h5>
                                        <p><?php echo $producto->getProDetalle() ?></p>
                                            <span>$<?php echo $producto->getProPrecio() ?></span>
                                        <?php
                                         ?>
                                    </div>
                                </div>
                                <?php
                                if ($sesion->activa()) {
                                    foreach ($sesion->getUsRoles() as $rol) {
                                        if ($rol == 3) {
                                ?>
                                            <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                                                <div class='text-center'>
                                                    <form method='post' action='../acciones/accionAgregarItemCarrito.php'>
                                                        <td class='text-center'>
                                                            <input name='codigoProducto' id='codigoProducto' type='hidden' value='<?php echo $producto->getIdProducto() ?>'>
                                                            <button class='btn btn-outline-dark mt-auto' type='submit' role='button'>Agregar al carrito</button>
                                                        </td>
                                                    </form>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                                        <div class='text-center'><a class='btn btn-outline-dark mt-auto' href='../acciones/iniciarSesion.php'>Agregar al carrito</a></div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
            <?php
                    }
                }
             ?>
        </div>
    </div>
</section>

<?php

//include_once '../estructura/footer.php';

?>