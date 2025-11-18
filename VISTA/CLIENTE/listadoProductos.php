<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$titulo = 'Listado de Productos';
include_once '../ACCION/ESTRUCTURA/reusables/header.php';
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
<body style="background-color: #858c96ff;">
<div class="container mt-2" >
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                if (count($listaProductos) > 0) {
                    for ($cont_prod = 0; $cont_prod <= count($listaProductos) - 1; $cont_prod++) {
                        $producto = $listaProductos[$cont_prod];
                        $idHash = md5($producto->getIdProducto());
                        $idHashImg = strtolower($idHash);
                        $deshabilitado = isset($producto->proDeshabilitado) ? $producto->proDeshabilitado : '0000-00-00 00:00:00'; //Defino la variable debido a que tira error
                        if ($deshabilitado == "0000-00-00 00:00:00" && $producto->getProCantStock() > 0) { ?>
                            <div class='col mb-5' >
                                <div class='card shadow h-100' style="background-color: #858c96ff;;">
                                    <?php
                                    //Los ifs siguientes son para los carteles avisando de las ultimas unidades
                                    if ($producto->getProCantStock() == 1) { ?>
                                        <div class='badge rounded-pill bg-danger position-absolute' style='top: 0.5rem; left: 0.5rem'><i class="fas fa-box"></i>&nbsp;Último en stock</span></div>
                                    <?php
                                    } else if ($producto->getProCantStock() > 1 && $producto->getProCantStock() <= 4) { ?>
                                        <div class='badge rounded-pill bg-warning position-absolute' style='top: 0.5rem; left: 0.5rem'><i class="fas fa-boxes"></i>&nbsp;Últimos en stock: <?php echo $producto->getProCantStock() ?></span></div>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    $imgWebBase = '../../uploads/img/'; //cargamos la ruta general de la imagen
                                    $imgCarpeta = realpath(__DIR__ . '/../../uploads/img/'); //Convertimos la ruta en una absoluta y la devolvemos como cadena
                                    $imgSrc = $imgWebBase . 'default.jpg'; //Asignamos la ruta por defecto que usara si no encuentra la imagen especifica
                                    $idProd= 'producto' . $producto->getIdProducto(); //obtenemos el id para que coincida la imagen con producto
                                    if ($imgCarpeta) {
                                        $exts = ['jpg', 'jpeg', 'png', 'webp', 'gif']; //revisa el tipo de extension que puede llegar a tener la imagen
                                        foreach ($exts as $ext) {
                                            $candidatePlain = $imgCarpeta . DIRECTORY_SEPARATOR . $idProd . '.' . $ext;
                                            if (file_exists($candidatePlain)) {
                                                $imgSrc = $imgWebBase . $idProd . '.' . $ext;
                                                break;
                                            }
                                        }
                                    }
                                    ?>

                                    <img class='card-img-top' src='<?php echo $imgSrc ?>' alt='<?php echo htmlspecialchars($producto->getProNombre(), ENT_QUOTES) ?>' />

                                    <div class='card-body p-4' >
                                        <div class='text-center'>
                                            <h5 class='fw-bolder'><?php echo $producto->getProNombre() ?></h5>
                                            <p><?php echo $producto->getProDetalle() ?></p>
                                            <span>$<?php echo $producto->getProPrecio() ?></span>
                                        </div>
                                    </div>
                                    <?php
                                    if ($sesion->activa()) {
                                       
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
</body>
<?php

//include_once '../estructura/footer.php';

?>
