<?php
require_once __DIR__ . '/../../UTILS/funciones.php';

include_once '../ACCION/ESTRUCTURA/reusables/header.php';
$datos = data_submitted();

if (!isset($datos["verificado"])) {
    $controlIngresoAdmin = new ControlIngresoAdmin();
    $controlIngresoAdmin->verificarIngreso("administrarUsuarios");
}

$titulo = 'Administración de Usuarios';

$abmUsuario = new AbmUsuario();
$listadoUsuarios = $abmUsuario->buscar(null);
$sesionAdministrarUsuarios = new Session();

print_r($sesionAdministrarUsuarios->getUsRoles()[0]->getObjRol()->getIdRol());

?>

<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            <h4>Listado Usuarios</h4>
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
                            <th scope="col" class='text-center'>ID</th>
                            <th scope="col" class='text-center'>Rol</th>
                            <th scope="col" class='text-center'>Usuario</th>
                            <th scope='col' class='text-center'>Contraseña</th>
                            <th scope="col" class='text-center'>Email</th>
                            <th scope="col" class='text-center'>Fecha Deshabilitado</th>
                            <th scope='col' class='text-center'></th>
                            <th scope='col' class='text-center'></th>
                            <th scope='col' class='text-center'></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($listadoUsuarios as $usuario) {
                            $id = $usuario->getIdUsuario();
                            $abmUsuarioRol = new AbmUsuarioRol();
                            $datos['idusuario'] = $id;
                            $listaUsuarioRol = $abmUsuarioRol->buscar($datos);
                            echo $listaUsuarioRol[0]->getObjRol()->getIdRol();
                            $rol = $listaUsuarioRol[0]->getObjRol()->getRolDescripcion(); ?>
                            <tr>
                                <td scope='row' class='text-center'><?php echo $id ?></td>
                                <?php
                                switch ($rol) {
                                    case 'Admin': ?>
                                        <td scope='row' class='text-center'><span class="badge rounded-pill bg-dark"><?php echo $rol ?></span></td>
                                    <?php
                                        break;
                                    case 'Manager Deposito': ?>
                                        <td scope='row' class='text-center'><span class="badge rounded-pill bg-success"><?php echo $rol ?></span></td>
                                    <?php
                                        break;
                                    default: ?>
                                        <td scope='row' class='text-center'><span class="badge rounded-pill bg-light text-dark"><?php echo $rol ?></span></td>
                                <?php
                                        break;
                                }
                                ?>

                                <td scope='row' class='text-center'><?php echo $usuario->getUsNombre() ?></td>
                                <td scope='row' class='text-center'><?php echo $usuario->getUsPass() ?></td>
                                <td scope='row' class='text-center'><?php echo $usuario->getUsmail() ?></td>

                                <?php
                                $estado = $usuario->getUsdeshabilitado();
                                if ($estado == "0000-00-00 00:00:00") {
                                    $estado = "";
                                }
                                ?>

                                <td scope='row'><?php echo $estado ?></td>

                                <?php
                                if ($id == $sesionAdministrarUsuarios->getIdUsuario()) { ?>
                                    <td scope='row' class='text-center'></td>
                                    <td scope='row' class='text-center'></td>
                                    <td scope='row' class='text-center'></td>
                            </tr>
                        <?php
                        } else { ?>
                        <?php
                            if($sesionAdministrarUsuarios->getUsRoles()[0]->getObjRol()->getIdRol() === 1){
                        ?>    
                            <form method='post' action='actualizarUsuarios.php'>
                                <td class='text-center'>
                                    <input name='idusuario' id='idusuario' type='hidden' value='<?php echo $id ?>'>
                                    <button class='btn btn-warning btn-sm' type='submit' role='button'><i class='bi bi-pencil-square'></i>&nbsp;Editar</button>
                                </td>
                            </form>
                        <?php
                            }
                        ?>
                            <?php
                            if($sesionAdministrarUsuarios->getUsRoles()[0]->getObjRol()->getIdRol() === 1){
                            ?>
                                <form method='post' action='eliminarUsuario.php'>
                                    <td class='text-center'>
                                        <input name='idusuario' id='idusuario' type='hidden' value='<?php echo $id ?>'>
                                        <button class='btn btn-danger btn-sm' type='submit' value='<?php $id ?>' role='button'><i class='bi bi-trash'></i>&nbsp;Eliminar</button>
                                    </td>
                                </form>
                            <?php
                            }
                            ?>

                            <form method='post' action='deshabilitarUsuario.php'>
                                <td class='text-center'>
                                    <input name='idusuario' id='idusuario' type='hidden' value='<?php echo $id ?>'>
                                    <?php
                                    if($sesionAdministrarUsuarios->getUsRoles()[0]->getObjRol()->getIdRol() === 1){ 
                                        if ($usuario->getUsdeshabilitado() == "0000-00-00 00:00:00") { ?>
                                            <button class='btn btn-secondary btn-sm' type='submit' value='<?php $id ?>' role='button'><i class='fas fa-ban'></i>&nbsp;Deshabilitar</button>
                                        <?php
                                        } else { ?>
                                            <button class='btn btn-success btn-sm' type='submit' value='<?php $id ?>' role='button'><i class="fas fa-check-circle"></i>&nbsp;Habilitar</button>
                                        <?php
                                        }
                                    }
                                    ?>
                                </td>
                            </form>
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