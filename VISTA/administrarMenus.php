<?php

include_once '../CONTROL/Session.php';

$session = new Session();
if(!$session->getIDSesionActual()){
    header("Location: ../index.php");

}else if($session->getIDSesionActual() != 1 && $session->getIDSesionActual()){
    header("Location: index.php");
}else{
    require_once __DIR__ . '/../UTILS/funciones.php';
    include_once 'ACCION/ESTRUCTURA/reusables/header.php';
}

$titulo = 'Administración de Menus';

$datos = data_submitted();

if (!isset($datos["verificado"])) {
    $controlIngresoAdmin = new ControlIngresoAdmin();
    $controlIngresoAdmin->verificarIngreso("administrarMenus");
}

$abmMenu = new AbmMenu();
$listadoMenus = $abmMenu->buscar(null);



?>

<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            <h4>Administración de Menus</h4>
        </div>
    </div>
</header>

<div class="container mt-2">
    <section class="py-2">
        <div class="">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class='text-center'>ID Menu</th>
                            <th scope="col" class='text-center'>ID Padre</th>
                            <th scope="col" class='text-center'>Nombre</th>
                            <th scope='col' class='text-center'>Descripción</th>
                            <th scope="col" class='text-center'>Fecha Deshabilitado</th>
                            <th scope='col' class='text-center'></th>
                            <th scope='col' class='text-center'></th>
                            <th scope='col' class='text-center'></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($listadoMenus as $menu) {
                            $id = $menu->getIdMenu(); ?>
                            <tr>
                                <td scope='row' class='text-center'><?php echo $id ?></td>
                                <td scope='row' class='text-center'><?php echo $menu->getIdPadre() ?></td>
                                <td scope='row' class='text-center'><?php echo $menu->getMeNombre() ?></td>
                                <td scope='row' class='text-center'><?php echo $menu->getMeDescripcion() ?></td>

                                <?php
                                $estado = $menu->getMeDeshabilitado();
                                if ($estado == "0000-00-00 00:00:00") {
                                    $estado = "";
                                }
                                ?>

                                <td scope='row'><?php echo $estado ?></td>

                                <?php
                                if ($menu->getIdPadre() == $id) { ?>
                                    <td scope='row' class='text-center'></td>
                                    <td scope='row' class='text-center'></td>
                                    <td scope='row' class='text-center'></td>
                            </tr>
                        <?php
                                } else { ?>
                            <form method='post' action='actualizarMenu.php'>
                                <td class='text-center'>
                                    <input name='idmenu' id='idmenu' type='hidden' value='<?php echo $id ?>'>
                                    <button class='btn btn-warning btn-sm' type='submit' role='button'><i class='bi bi-pencil-square'></i>&nbsp;Editar</button>
                                </td>
                            </form>

                            <form method='post' action='acciones/eliminarMenu.php'>
                                <td class='text-center'>
                                    <input name='idmenu' id='idmenu' type='hidden' value='<?php echo $id ?>'>
                                    <button class='btn btn-danger btn-sm' type='submit' value='<?php $id ?>' role='button'><i class='bi bi-trash'></i>&nbsp;Eliminar</button>
                                </td>
                            </form>


                            <form method='post' action='acciones/accionDeshabilitarMenu.php'>
                                <td class='text-center'>
                                    <input name='idmenu' id='idmenu' type='hidden' value='<?php echo $id ?>'>
                                    <?php
                                    if ($menu->getMeDeshabilitado() == "0000-00-00 00:00:00") { ?>
                                        <button class='btn btn-secondary btn-sm' type='submit' value='<?php $id ?>' role='button'><i class='fas fa-ban'></i>&nbsp;Deshabilitar</button>
                                    <?php
                                    } else { ?>
                                        <button class='btn btn-success btn-sm' type='submit' value='<?php $id ?>' role='button'><i class="fas fa-check-circle"></i>&nbsp;Habilitar</button>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </form>
                            </tr>
                             <?php
                                }
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<?php
include_once '../VISTA/ACCION/ESTRUCTURA/reusables/footer.php';
?>