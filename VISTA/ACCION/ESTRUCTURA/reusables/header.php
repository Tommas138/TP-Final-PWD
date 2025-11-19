<?php
include_once __DIR__ . '../../../../../UTILS/funciones.php';

$cantidadItemsCarrito = 0;
$sesion = new Session();

if ($sesion->activa()) {
        
    $user = $sesion->getUsuario();


    $name = $user->getUsNombre();
    $idUser = $user->getIdUsuario();
}
$enlace = "";
?>
<nav class="navbar navbar-expand-custom navbar-mainbg">

        <a class="navbar-brand navbar-logo" href="#">Dunder Mifflin Store</a>
        <a class="navbar-brand navbar-logo" href="../../VISTA/home/index.php">Inicio</a>
        <a class="navbar-brand navbar-logo" href="../../VISTA/CLIENTE/listadoProductos.php">Productos</a>
        <?php 
        $objUs = new UsuarioRol();
        $arrUs = $objUs->listar("idusuario = $idUser");
        if ($arrUs[0]->getObjRol()->getIdRol() == 1) {
            ?>
            <a class="navbar-brand navbar-logo" href="../../VISTA/acciones/accionActualizarMenu.php">Administrar Menu</a>
            <a class="navbar-brand navbar-logo" href="../../VISTA/MANAGERDEPOSITO/administrarCompras.php">Administrar Compras</a>
            <?php
        }
        ?>
        <div class="bg-primary text-white p-2 rounded">
                <form action="../../VISTA/acciones/cerrarSesion.php">
                        <button type="submit" class="btn btn-sm">
                                Cerrar Sesión
                        </button>
                </form>
        </div>
        <?php
                    if ($sesion->activa()) {
                        $roles = $sesion->getUsRoles();
                        // Ensure menu arrays are defined to avoid undefined warnings
                        $arrayMenus = [];
                        $arraySubMenus = [];

                        foreach ($roles as $rol) {
                            // Normalize role id whether $rol is an object, array or scalar
                            $roleId = null;
                            if (is_object($rol)) {
                                if (method_exists($rol, 'getIdRol')) {
                                    $roleId = $rol->getIdRol();
                                } elseif (method_exists($rol, 'getObjRol')) {
                                    $obj = $rol->getObjRol();
                                    if (is_object($obj) && method_exists($obj, 'getIdRol')) {
                                        $roleId = $obj->getIdRol();
                                    } elseif (is_array($obj) && isset($obj['idrol'])) {
                                        $roleId = $obj['idrol'];
                                    }
                                }
                            } elseif (is_array($rol) && isset($rol['idrol'])) {
                                $roleId = $rol['idrol'];
                            } else {
                                // assume scalar (id) value
                                $roleId = $rol;
                            }

                            if ($roleId === null) {
                                continue; // skip if we couldn't determine a role id
                            }

                            $abmMenuRol = new AbmMenuRol();
                            $arrayMenusRol = $abmMenuRol->buscar(['idrol' => $roleId]);

                            if (count($arrayMenusRol) > 0) {
                                $abmMenu = new AbmMenu();
                                $idMenu = $arrayMenusRol[0]->getObjMenu()->getIdMenu();
                                $arrayMenus = $abmMenu->buscar(['idmenu' => $idMenu]);
                                if (count($arrayMenus) > 0) {
                                    $idPadre = $arrayMenus[0]->getIdMenu();
                                    $arraySubMenus = $abmMenu->buscar(["idpadre" => $idPadre]);
                                }
                            }

                            foreach ($arrayMenus as $menu) {
                                if ($menu->getMeDeshabilitado() == "0000-00-00 00:00:00") {
                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $menu->getMeNombre(); ?></a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <?php
                                            foreach ($arraySubMenus as $subMenu) {
                                                if ($subMenu->getMeDeshabilitado() == "0000-00-00 00:00:00") {
                                                    switch ($roleId) {
                                                        case '1':
                                                            $enlace .= "../admin/";
                                                            break;
                                                        case '2':
                                                            $enlace .= "../managerDeposito/";
                                                            break;
                                                        case '3':
                                                            $enlace .= "../cliente/";
                                                            break;
                                                    }
                                            ?>
                                                    <li><a class="dropdown-item" href="<?php echo $enlace .= $subMenu->getMeDescripcion() . '.php' ?>"><?php echo $subMenu->getMeNombre(); ?></a></li>
                                            <?php
                                                    $enlace = "";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                    <?php
                                }
                            }
                        }
                    }
                    ?>
</nav>