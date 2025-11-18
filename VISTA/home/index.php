<?php
require_once __DIR__ . '/../../UTILS/funciones.php';
require_once __DIR__ . '../../ACCION/ESTRUCTURA/reusables/header.php';

$titulo = 'Dunder Mifflin Store';

$sesion = new Session();

$abmProductos = new AbmProducto();
$listaProductos = $abmProductos->buscar(null);
shuffle($listaProductos);

?>
<!-- Header-->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo $titulo; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZmCNUxC+GQYUQDFN1VqM7uH60lZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" 
          referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../acciones/ESTRUCTURA/styles.css">
</head>
<nav class="navbar navbar-expand-custom navbar-mainbg">

        <a class="navbar-brand navbar-logo" href="#">Dunder Mifflin Store</a>
        <div class="bg-primary text-white p-2 rounded">
                <form action="../acciones/cerrarSesion.php">
                        <button type="submit" class="btn btn-sm">
                                Cerrar Sesión
                        </button>
                </form>
        </div>
</nav>
<!-- Section-->
<section class="py-2">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            print_r($sesion->mostrarDetallesSesion());
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
                                        $imgRel = '../../uploads/img/producto1.jpg';
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
                                if ($sesion->activa() && $sesion->getIDRol() == 1) {
                                    // foreach ($sesion->getUsRoles() as $rol) {
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
                                        
                                    // }
                                } else {
                                    print_r($sesion->getIDRol() . "ID ROL");

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