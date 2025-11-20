<?php
$titulo = 'Deshabilitación de Producto';

require_once __DIR__ . '/../../UTILS/funciones.php';
include_once '../ACCION/ESTRUCTURA/reusables/header.php';

$datos = data_submitted();

$abmProducto = new AbmProducto();

$id = $datos['idproducto'];

$producto = $abmProducto->buscar(['idproducto' => $id]);
?>

<div class="container mt-5">
    <div class="card text-center">
        <div class="card-header">
            Deshabilitación del producto
        </div>
        <div class="card-body">
            <?php
            if ($producto[0]->getProDeshabilitado() == "0000-00-00 00:00:00") { ?>
                <h5 class="card-title">¿Desea deshabilitar temporalmente el producto?</h5>
            <?php
            } else { ?>
                <h5 class="card-title">¿Desea habilitar nuevamente el producto?</h5>
            <?php
            }
            ?>
            <p class="card-text">Código: <?php echo $id ?></p>
            <form action='../acciones/accionDeshabilitarProducto.php' method='post'>
                <input name='idproducto' id='idproducto' type='hidden' value='<?php echo $id ?>'>
                <?php
                if ($producto[0]->getProDeshabilitado() == "0000-00-00 00:00:00") { ?>
                    <button class='btn btn-danger btn-sm' type='submit' value='<?php $id ?>' role='button'>Deshabilitar</button>
                <?php
                } else { ?>
                    <button class='btn btn-success btn-sm' type='submit' value='<?php $id ?>' role='button'>Habilitar</button>
                <?php
                }
                ?>
            </form>
        </div>
    </div>
</div>

<?php

include_once '../../VISTA/ACCION/ESTRUCTURA/reusables/footer.php';

?>