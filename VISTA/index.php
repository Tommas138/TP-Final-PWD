<style>
    nav {
        position:absolute;
    }
    body {
        position: relative;
    }
    #footer {
        height: 100px;
        left: 0px;
    }
    #small {
        font-size:1.2rem;
    }
</style>
<?php

require_once __DIR__ . '/../UTILS/funciones.php';
$titulo = 'Dunder Mifflin Store';

//$sesion = new Session();



require_once __DIR__ . '../ACCION/ESTRUCTURA/reusables/headerInicio.php';
$abmProductos = new AbmProducto();
$listaProductos = $abmProductos->buscar(null);
shuffle($listaProductos);


// if($sesion->getIDSesionActual()){


?>
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
    <link rel="stylesheet" href="acciones/ESTRUCTURA/styles.css">
</head>
<body>
<div class="container mt-5">
    <section class="py-4">
        <?php
        //print_r($sesion->mostrarDetallesSesion());
        if (count($listaProductos) > 0) {
            $max = min(count($listaProductos), 4);
            ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php
            for ($cont_prod = 0; $cont_prod < $max; $cont_prod++) {
                $producto = $listaProductos[$cont_prod];
        ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 transition-hover">
                        <?php
                        $imgWebBase = '../uploads/img/';
                        $imgCarpeta = realpath(__DIR__ . '/../uploads/img/');
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
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <img src="<?php echo $imgSrc ?>" 
                                 class="card-img-top w-100 h-100 object-fit-cover" 
                                 alt="<?php echo htmlspecialchars($producto->getProNombre(), ENT_QUOTES) ?>" />
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-center mb-2">
                                <?php echo htmlspecialchars($producto->getProNombre(), ENT_QUOTES) ?>
                            </h5>
                            <p class="card-text text-muted small text-center flex-grow-1">
                                <?php echo htmlspecialchars($producto->getProDetalle(), ENT_QUOTES) ?>
                            </p>
                            <div class="text-center mt-auto">
                                <span class="fs-4 fw-bold text-primary">
                                    $<?php echo number_format($producto->getProPrecio(), 2) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 p-3">
                            <div class="d-grid justify-content-center gap-2">
                                <form method='post' action='acciones/accionAgregarItemCarrito.php'>
                                    <td>
                                        <input name='idproducto' id='idproducto' type='hidden' value='<?php echo $producto->getIdProducto() ?>'>
                                        <button class="add-carrito-button" type='submit' role='button'>Agregar al carrito</button>
                                    </td>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            }
            ?>
            </div></body>
            <?php
        }
require_once __DIR__ . '../ACCION/ESTRUCTURA/reusables/footer.php';
?>
    </section>
</div>