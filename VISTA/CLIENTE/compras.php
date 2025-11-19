<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

$datos = data_submitted();

if (!isset($datos["verificado"])) {
    $controlIngresoCarrito = new ControlIngresoCliente();
    $controlIngresoCarrito->verificarIngreso("compras");
}

$titulo = 'Historial de Compras';
include_once '../ACCION/ESTRUCTURA/reusables/header.php';


$sesion = new Session();
$user = $sesion->getUsuario();
$idUser = $user->getIdUsuario();

// $abmCompras = new AbmCompra();
// $listaCompras = $abmCompras->buscar(['idusuario'=>$idUser]);

$controlVerificarCarrito = new ControlVerificarCarritoCliente();
$arrayCarritos = $controlVerificarCarrito->verificarCarrito($idUser);
$compras = $arrayCarritos['arrayCompras'];

?>
<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            <h4>Historial de Compras</h4>
        </div>
    </div>
</header>

<div class="container mt-2">
    <section class="py-2">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <table class='table align-middle'>
                    <thead class='table-dark'>
                        <tr class='align-middle'>
                            <th scope='col' class='text-center'>ID Compra</th>
                            <th scope='col' class='text-center'>Estado</th>
                            <th scope='col' class='text-center'>Fecha Inicio Compra</th>
                            <th scope='col' class='text-center'>Fecha Fin Compra</th>
                            <th scope='col' class='text-center'></th>
                            <th scope='col' class='text-center'></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (count($compras) > 0) {
                            foreach ($compras as $compra) {
                                $idCompra = $compra->getIdCompra();
                                $abmCompraEstado = new AbmCompraEstado();
                                $compraEstado = $abmCompraEstado->buscar(['idcompra' => $idCompra]);
                                $idCompraEstado = $compraEstado[0]->getIdCompraEstado();
                        ?>
                                <tr>
                                    <td class='text-center'><?php echo $idCompra ?></td>
                                    <?php
                                    $idEstadoCompraTipo = $compraEstado[0]->getIdCompraEstadoTipo()->getIdCompraEstadoTipo();
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
                                    <td class='text-center'><?php echo $estadoCompra ?></td>
                                    <td class='text-center'><?php echo $compraEstado[0]->getCeFechaIni() ?></td>
                                    <?php
                                    $fechaFin = $compraEstado[0]->getCeFechaFin();
                                    if ($fechaFin == null) {
                                        $fechaFin = "";
                                    }
                                    ?>
                                    <td class='text-center'><?php echo $fechaFin ?></td>
                                    <form method='post' action='verCompra.php'>
                                        <td class='text-center'>
                                            <input name='idcompra' id='idcompra' type='hidden' value='<?php echo $idCompra ?>'>
                                            <button class='btn btn-warning btn-sm' type='submit' role='button'><i class="fas fa-shopping-cart"></i>&nbsp;Ver Items</button>
                                        </td>
                                    </form>
                                    <?php
                                    if ($idEstadoCompraTipo == 1) {
                                    ?>
                                        <form method='post' action='../acciones/accionFinCompra.php'>
                                            <td class='text-center'>
                                                <input name='idcompraestado' id='idcompraestado' type='hidden' value='<?php echo $idCompraEstado ?>'>
                                                <button class='btn btn-danger btn-sm' type='submit' role='button'><i class='bi bi-cart-x'></i>&nbsp;Cancelar</button>
                                            </td>
                                        </form>
                                    <?php
                                    } else {
                                    ?>
                                        <td scope='row' class='text-center'></td>
                                    <?php
                                    }
                                    ?>

                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php



?>