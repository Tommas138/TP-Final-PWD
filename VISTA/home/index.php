<?php

require_once __DIR__ . '/../../UTILS/funciones.php';
$titulo = 'Dunder Mifflin Store';

//$sesion = new Session();



require_once __DIR__ . '../../ACCION/ESTRUCTURA/reusables/headerInicio.php';
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
<!-- Section-->
<div class="container mt-2 d-flex justify-content-center">
    <section class="py-2">
        <?php
        //print_r($sesion->mostrarDetallesSesion());
        if (count($listaProductos) > 0) {
            $max = min(count($listaProductos), 4);
            for ($cont_prod = 0; $cont_prod < $max; $cont_prod++) {
                $producto = $listaProductos[$cont_prod];
        ?>

                <div class='row mb-4 object-fit-contain'>
                    <div class='card shadow align-items-center'>
                        <?php
                        $imgWebBase = '../../uploads/img/';
                        $imgCarpeta = realpath(__DIR__ . '/../../uploads/img/');
                        $imgSrc = $imgWebBase . 'default.jpg';
                        $idPlain = 'producto' . intval($producto->getIdProducto());
                        $idHashImg = strtolower(md5($producto->getIdProducto()));
                        if ($imgCarpeta) {
                            $exts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                            foreach ($exts as $ext) {
                                $candidateHash = $imgCarpeta . DIRECTORY_SEPARATOR . $idHashImg . '.' . $ext;
                                $candidatePlain = $imgCarpeta . DIRECTORY_SEPARATOR . $idPlain . '.' . $ext;
                                if (file_exists($candidateHash)) {
                                    $imgSrc = $imgWebBase . $idHashImg . '.' . $ext;
                                    break;
                                }
                                if (file_exists($candidatePlain)) {
                                    $imgSrc = $imgWebBase . $idPlain . '.' . $ext;
                                    break;
                                }
                            }
                        }
                        ?>
                        <img class='card shadow-sm m-3 ' style="width: 300px; height: 300px;" src='<?php echo $imgSrc ?>' alt='<?php echo htmlspecialchars($producto->getProNombre(), ENT_QUOTES) ?>' />

                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h5 class='fw-bolder'><?php echo $producto->getProNombre() ?></h5>
                                <p><?php echo $producto->getProDetalle() ?></p>
                                <span>$<?php echo $producto->getProPrecio() ?></span>
                            </div>
                        </div>

                    </div>
                </div>
</div>

</div>
<?php
            }
        }
?>
</section>
</div>

<?php

//include_once '../estructura/footer.php';

?>