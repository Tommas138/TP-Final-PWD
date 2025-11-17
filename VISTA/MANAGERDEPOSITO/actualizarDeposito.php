<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$titulo = 'Actualizacion de Productos';

include_once '../estructura/header.php';

$datos = data_submitted();
$abmProducto = new AbmProducto();

$arrayBusqueda = ["idproducto" => $datos['idproducto']];

$listaProductos = $abmProducto->buscar($arrayBusqueda);
$objProducto = $listaProductos[0];

?>

<div class="container mt-3">
    <h1 class="text-center">Actualizar producto</h1>
    <div class="col-md-4"></div>
    <div class="offset-md-4">
        <form action="../acciones/accionActualizarProducto.php" method="post" enctype="multipart/form-data" class="col-md-6 mt-3 " id="actualizarProducto" name="actualizarProducto">
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="idproducto" name="idproducto" type="text" placeholder="Codigo producto" value="<?php echo $objProducto->getIdProducto() ?>" hidden>
                    <label for="idproducto">Codigo del producto: </label>
                </div>
            </div>

            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="pronombre" name="pronombre" type="text" placeholder="Nombre producto" value="<?php echo $objProducto->getProNombre() ?>" required>
                    <label for="pronombre">Nombre del producto: </label>
                </div>
            </div>

            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="prodetalle" name="prodetalle" type="text" placeholder="Detalle producto" value="<?php echo $objProducto->getProDetalle() ?>" required>
                    <label for="prodetalle">Detalle del producto: </label>
                </div>
            </div>


            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="procantstock" name="procantstock" type="text" placeholder="Stock producto" value="<?php echo $objProducto->getProCantStock() ?>" required>
                    <label for="procantstock">Stock del producto: </label>
                </div>
            </div>


            <div class="col-md-6">
                <div class="mt-3">
                    <label class="mb-2" for="imagen">Imagen de producto</label>
                    <input type="file" name="imagen" id="imagen">
                </div>
            </div>

            <div class="mt-3">
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Modificar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php

include_once '../estructura/footer.php';

?>