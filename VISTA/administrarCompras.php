<style>
    nav {
        position:absolute;
    }
    body {
        height: 1800px;
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

include_once 'ACCION/ESTRUCTURA/reusables/header.php';
$titulo = 'Administración de Compras';

$datos = data_submitted();

if (!isset($datos["verificado"])) {
    $controlIngresoManagerDeposito = new ControlIngresoManagerDeposito();
    $controlIngresoManagerDeposito->verificarIngreso("administrarCompras");
}

$abmComprasIniciadas = new AbmCompraEstado();
$listaComprasIniciadas = $abmComprasIniciadas->buscar(null);

?>
<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            <h4>Listado de Compras</h4>
        </div>
    </div>
</header>

<body>
<div class="container mt-2">
    <section class="py-2">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <table class='table align-middle'>
                    <thead class='table-dark'>
                        <tr class='align-middle'>
                            <th scope='col' class='text-center'>ID Compra</th>
                            <th scope='col' class='text-center'>Usuario</th>
                            <th scope='col' class='text-center'>Estado</th>
                            <th scope='col' class='text-center'>Fecha Inicio Compra</th>
                            <th scope='col' class='text-center'>Fecha Fin Compra</th>
                            <th scope='col' class='text-center'></th>
                            <th scope='col' class='text-center'></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (count($listaComprasIniciadas) > 0) {
                            foreach ($listaComprasIniciadas as $compra) {
                                $objCompra = $compra->getIdCompra();
                                $idCompra = $objCompra->getIdCompra();
                                $idCompraEstado = $compra->getIdCompraEstado();
                                $objCliente = $objCompra->getIdUsuario();
                        ?>
                                <tr>
                                    <td class='text-center'><?php echo $idCompra ?></td>
                                    <?php
                                    $idEstadoCompraTipo = $compra->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();
                                    switch ($idEstadoCompraTipo) {
                                        case '2':
                                            $estadoCompra = '<span class="badge rounded-pill bg-warning text-dark">Aceptada</span>';
                                            break;
                                        case '3':
                                            $estadoCompra = '<span class="badge rounded-pill bg-success">Enviada</span>';
                                            break;
                                        case '4':
                                            $estadoCompra = '<span class="badge rounded-pill bg-danger">Cancelada</span>';
                                            break;
                                        default:
                                            $estadoCompra = '<span class="badge rounded-pill bg-primary">Iniciada</span>';
                                            break;
                                    }
                                    ?>
                                    <td class='text-center'><?php echo $objCliente->getUsNombre() ?></td>
                                    <td class='text-center'><?php echo $estadoCompra ?></td>
                                    <td class='text-center'><?php echo $compra->getCeFechaIni() ?></td>
                                    <?php
                                    $fechaFin = $compra->getCeFechaFin();
                                    if ($fechaFin == null) {
                                        $fechaFin = "";
                                    }
                                    ?>
                                    <td class='text-center'><?php echo $fechaFin ?></td>
                                    <?php
                                    if ($idEstadoCompraTipo == 1) {
                                    ?>
                                        <form method='post' action='acciones/accionAceptarCompra.php'>
                                            <td class='text-center'>
                                                <input name='idcompraestado' id='idcompraestado' type='hidden' value='<?php echo $idCompra ?>'>
                                                <button class='btn btn-warning btn-sm' type='submit' role='button'><i class='bi bi-cart-check-fill'></i>&nbsp;Aceptar</button>
                                            </td>
                                        </form>
                                    <?php
                                    } else if ($idEstadoCompraTipo == 2) {
                                    ?>
                                        <form method='post' action='acciones/accionEnviarCompra.php'>
                                            <td class='text-center'>
                                                <input name='idcompraestado' id='idcompraestado' type='hidden' value='<?php echo $idCompra ?>'>
                                                <button class='btn btn-warning btn-sm' type='submit' role='button'><i class='fas fa-shipping-fast'></i>&nbsp;Enviar</button>
                                            </td>
                                        </form>
                                    <?php
                                    } else { ?>
                                        <td class='text-center'></td>
                                    <?php
                                    }

                                    if ($idEstadoCompraTipo <= 3) { ?>
                                        <form method='post' action='acciones/accionFinCompra.php'>
                                            <td class='text-center'>
                                                <input name='idcompraestado' id='idcompraestado' type='hidden' value='<?php echo $idCompraEstado ?>'>
                                                <button class='btn btn-danger btn-sm' type='submit' role='button'><i class='bi bi-cart-x'></i>&nbsp;Cancelar</button>
                                            </td>
                                        </form>
                                    <?php
                                    } else { ?>
                                        <td class='text-center'></td>
                            <?php
                                    }
                                }
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
</body>

<?php
include_once '../VISTA/ACCION/ESTRUCTURA/reusables/footer.php';

?>