
<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$datos = data_submitted();

$sesion = new Session();

if ($sesion->activa()) {
    $user = $sesion->getUsuario();
    $idUser = $user->getIdUsuario();
}

$titulo = 'Compra';

include_once '../ACCION/ESTRUCTURA/reusables/header.php';
$abmItemsCompra = new AbmCompraItem();
$compraItems = $abmItemsCompra->buscar($datos);
$subTotalCompra = 0;
$iva = 0;
$totalFinalCompra = 0;

?>
<div class="container mt-2">
    <section>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-light shadow wish-list mb-3">
                    <div class="card-body">
                        <?php
                        $subTotalCompra = 0;
                        $iva = 0;
                        $totalFinalCompra = 0;
                       
                         if (count($compraItems)) {

                            foreach ($compraItems as $compraItem) {
                                $producto = $compraItem->getIdProducto();
                                $id = $producto->getIdProducto();
                                $precio = $producto->getProPrecio();
                                $unidades = $compraItem->getCiCantidad();
                                $subTotalProducto = ($precio * $unidades) - ((($precio * $unidades)) / 100);
                                $subTotalCompra = $subTotalCompra + $subTotalProducto;
                                $imgCarpeta = realpath(__DIR__ . '/../../uploads/img/');
                                $idHash = md5($producto->getIdProducto());
                                $idHashImg = strtolower($idHash);
                                $idPlain = 'producto' . intval($producto->getIdProducto());
                                $imgWebBase = '../../uploads/img/';
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
                                <div class="row mb-4">
                                    <div class="col-md-5 col-lg-3 col-xl-3">
                                        <div>
                                            <img class='card-img-top img-producto-listado' src='../../uploads/img/<?php echo $imgSrc; ?>' alt='Imagen de un suplemento' />
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-lg-9 col-xl-9">
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h4><?php echo $producto->getProNombre() ?></h4>
                                                    <p class="mb-3 text-muted text-uppercase small">Modelo: <?php echo $producto->getProDetalle() ?></p>
                                                </div>
                                                <div class='text-center'>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <?php
                                                        if ($unidades == 1) { ?>
                                                            <span class="input-group-text" id="basic-addon1">Unidad: <?php echo $unidades ?></span>
                                                        <?php
                                                        } else { ?>
                                                            <span class="input-group-text" id="basic-addon1">Unidades: <?php echo $unidades ?></span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0"><span>Precio x unidad: <strong>$<?php echo $precio ?>.-</strong></span></p>
                                            </div>
                                            <?php
                                            $stockFinal = $producto->getProcantstock() - $unidades;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-4">
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-light shadow mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Detalles compra:</h5>
                        <?php
                        $iva = $subTotalCompra * 0.21;
                        $totalFinalCompra = $subTotalCompra + $iva;
                        ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Subtotal
                                <span>$<?php echo round($subTotalCompra, 2); ?>.-</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                IVA (21%)
                                <span>$<?php echo round($iva, 2); ?>.-</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Total Final</strong>
                                    <p class="mb-0 text-muted fw-light">(Incluyendo IVA)</p>
                                </div>
                                <span><strong>$<?php echo round($totalFinalCompra, 2); ?>.-</strong></span>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="compras.php"><button class='btn btn-success m-1' type='submit' role='button'>Volver al historial</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include_once '../../VISTA/ACCION/ESTRUCTURA/reusables/footer.php';
?>
