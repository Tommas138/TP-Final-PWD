<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$titulo = 'Listado de Productos';
include_once '../estructura/header.php';
$sesion = new Session();
$abmProductos = new AbmProducto();
$listaProductos = $abmProductos->buscar(null);
?>
<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            <h4>Listado de Productos</h4>
        </div>
    </div>
</header>
<div class="container mt-2">
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                if (count($listaProductos) > 0) {
                    for ($cont_prod = 0; $cont_prod <= count($listaProductos) - 1; $cont_prod++) {
                        $producto = $listaProductos[$cont_prod];
                        $idHash = md5($producto->getIdProducto());
                        $idHashImg = strtolower($idHash);
                        if ($deshabilitado == "0000-00-00 00:00:00" && $producto->getProCantStock() > 0) { ?>
                            <div class='col mb-5'>
                                <div class='card shadow h-100'>
                                    <?php
                                    if ($producto->getProCantStock() == 1) { ?>
                                        <div class='badge rounded-pill bg-danger position-absolute' style='top: 0.5rem; left: 0.5rem'><i class="fas fa-box"></i>&nbsp;Último en stock</span></div>
                                    <?php
                                    } else if ($producto->getProCantStock() > 1 && $producto->getProCantStock() <= 4) { ?>
                                        <div class='badge rounded-pill bg-warning position-absolute' style='top: 0.5rem; left: 0.5rem'><i class="fas fa-boxes"></i>&nbsp;Últimos en stock: <?php echo $producto->getProCantStock() ?></span></div>
                                    <?php
                                    }

                                    if ($producto->getProDescuento() > 0) { ?>
                                        <div class='badge bg-dark text-white position-absolute' style='top: 0.5rem; right: 0.5rem'>Oferta<span>&nbsp;<?php echo $producto->getProDescuento() ?>%</span></div>
                                    <?php
                                    } ?>

                                    <img class='card-img-top' src='../../uploads/img/<?php echo $idHashImg . ".jpeg"; ?>' alt='' />

                                    <div class='card-body p-4'>
                                        <div class='text-center'>
                                            <h5 class='fw-bolder'><?php echo $producto->getProNombre() ?></h5>
                                            <p><?php echo $producto->getProDetalle() ?></p>
                                            <?php
                                            if ($producto->getProDescuento() > 0) {
                                                $precio = $producto->getProPrecio();
                                                ?>
                                                <span class='text-muted text-decoration-line-through'>$<?php echo $precio ?></span>&nbsp;$
                                            <?php } else { ?>
                                                <span>$<?php echo $producto->getProPrecio() ?></span>
                                            <?php
                                            } ?>
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
                                            <div class='text-center'><a class='btn btn-outline-dark mt-auto' href='../login/login.php'>Agregar al carrito</a></div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                <?php
                        }
                    }
                } ?>
            </div>
        </div>
    </section>
</div>

<?php

include_once '../estructura/footer.php';

?>
