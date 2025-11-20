<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php
include_once __DIR__ . '../../../../../UTILS/funciones.php';
include_once __DIR__ . '/../../../../CONTROL/AbmRol.php';
include_once __DIR__ . '/../../../../MODELO/UsuarioRol.php';
include_once __DIR__ . '/../../../../CONTROL/AbmMenuRol.php';


$cantidadItemsCarrito = 0;
$sesion = new Session();

if ($sesion->activa()) {

    // $user = $sesion->getUsuario();
    // $name = $user->getUsNombre();
    // $idUser = $user->getIdUsuario();

    $user = $sesion->getUsuario();
    $name = $sesion->getUsNombre();
    $idUser = $sesion->getIdUsuario();
}
$enlace = "";
?>
<nav class="navbar navbar-expand-custom navbar-mainbg">

    <a class="navbar-brand navbar-logo navbar-button " href="../../VISTA/home/index.php">Dunder Mifflin Store</a>
    <a class="navbar-brand navbar-logo navbar-button" href="../../VISTA/CLIENTE/listadoProductos.php">Productos</a>
    <?php
    $objUs = new UsuarioRol();
    $arrUs = $objUs->listar("idusuario = $idUser");
    if ($arrUs[0]->getObjRol()->getIdRol() == 1) {
    }
    ?>
    <div class="bg-primary text-white p-2 rounded">
        <form action="../../VISTA/acciones/cerrarSesion.php">
            <button type="submit" class="btn btn-sm">
                Cerrar Sesión
            </button>
        </form>
    </div>
    </nav>
      <nav style="height: 50px;">
   <?php
   
     if ($sesion->activa()) {
                        $roles = $sesion->getUsRoles();
                        // print_r($roles);
                        print_r($sesion->getIDRol());
                        foreach ($sesion->getUsRoles() as $rol) {

                            $abmMenuRol = new AbmMenuRol();
                            $arrayMenus = null;
                            $arrayMenusRol = $abmMenuRol->buscar(['idrol' => $sesion->getIDSesionActual()]);

                            if (count($arrayMenusRol) > 0) {
                                $abmMenu = new AbmMenu();
                                $idMenu = $arrayMenusRol[0]->getObjMenu()->getIdMenu();
                                $arrayMenus = $abmMenu->buscar(["idmenu" => $idMenu]);
                                if (count($arrayMenus) > 0) {
                                    $idPadre = $arrayMenus[0]->getIdMenu();
                                    $arraySubMenus = $abmMenu->buscar(["idpadre" => $idPadre]);
                                }
                            }
                            foreach ($arrayMenus as $menu) {
                               
                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $menu->getMeNombre(); ?></a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <?php
                                            foreach ($arraySubMenus as $subMenu) {
                                                    switch ($rol->getObjRol()->getIdRol()) {
                                                        case '1':
                                                            $enlace .= "../ADMIN/";
                                                            break;
                                                        case '2':
                                                            $enlace .= "../MANAGER/";
                                                            break;
                                                        case '3':
                                                            $enlace .= "../CLIENTE/";
                                                            break;
                                                    }
                                            ?>
                                                    <li><a class="dropdown-item" href="<?php echo $enlace .= $subMenu->getMedescripcion() . '.php' ?>"><?php echo $subMenu->getMeNombre(); ?></a></li>
                                            <?php
                                                    $enlace = "";
                                                }
                                            
                                            ?>
                                        </ul>
                                    </li>
                    <?php
                                
                            }
                        }
                    }
                    ?>
                </ul>
                <ul class="navbar-nav d-flex">
                    <!-- Icon carrito -->
                    <?php
                    if (($sesion->activa())) {
                        $clienteActivo = false;

                        foreach ($roles as $rol) {
                            if ($rol->getObjRol()->getIdRol() == 3) {
                                $clienteActivo = true;
                            }
                        }

                        if ($clienteActivo) {
                            $controlVerificarCarrito = new controlVerificarCarritoCliente();
                            $arrayCarritos = $controlVerificarCarrito->verificarCarrito($idUser);
                            $carrito = $arrayCarritos['carritoHabilitado'];

                            if ($carrito <> "") {
                                $abmItemsCarrito = new AbmCompraItem();
                                $compraItems = $abmItemsCarrito->buscar(['idcompra' => $carrito->getIdCompra()]);
                                $cantidadItemsCarrito = count($compraItems);
                            }
                        }

                        if ($rol->getObjRol()->getIdRol() == 3) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../cliente/carrito.php" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-shopping-cart"></i> <span class="d-lg-none">Carrito</span><span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cantidadItemsCarrito; ?></span>
                                </a>
                            </li>
                        <?php
                        }
                    }
                    if (!$sesion->activa()) { ?>
                        <!-- Visitante -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-Visitante" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-sign-in-alt"></i></a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown-Visitante">
                                <a class="dropdown-item" href="../login/login.php"><i class="fas fa-sign-in-alt fa-fw"></i>&nbsp;Entrar</a>
                                <a class="dropdown-item" href="../login/registrar.php"><i class="fas fa-pencil-alt fa-fw"></i>&nbsp;Registrarse</a>
                            </div>
                        </li>
                    <?php
                    } else { ?>
                        <!-- Usuario logeado -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-Usuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i><span class="">&nbsp;&nbsp;<?php echo $name ?></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown-Usuario">
                                <?php
                                switch ($roles[0]->getObjRol()->getIdRol()) {
                                    case 1: ?>
                                        <a class="dropdown-item" disabled="disabled">&nbsp;<i class="fas fa-id-badge"></i>&nbsp;&nbsp;Rol: Admin</a>
                                    <?php
                                        break;
                                    case 2: ?>
                                        <a class="dropdown-item" disabled="disabled">&nbsp;<i class="fas fa-id-badge"></i>&nbsp;&nbsp;Rol: Depósito</a>
                                    <?php
                                        break;
                                    default: ?>
                                        <a class="dropdown-item" disabled="disabled">&nbsp;<i class="fas fa-id-badge"></i>&nbsp;&nbsp;Rol: Cliente</a>
                                <?php
                                        break;
                                }
                                ?>

                                <a class="dropdown-item" href="../login/perfil.php"><i class="fas fa-user-cog"></i>&nbsp;Modificar Perfil</a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item logout" href="../login/logout.php"><i class="fas fa-sign-out-alt fa-fw"></i>&nbsp;Cerrar sesión</a>
                            </div>
                        </li>
                        <?php
                        if ($roles[0]->getObjRol()->getIdRol() < 3) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-Usuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-eye"></i>&nbsp;Ver Como
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown-Usuario">

                                    <?php
                                    for ($i = 3; $i >= $roles[0]->getObjRol()->getIdRol(); $i--) {
                                        $idRolAction = md5($i);
                                        switch ($i) {
                                            case 1:
                                                $rol = "<i class='fas fa-user-shield'></i>&nbsp;Administrador";
                                                break;
                                            case 2:
                                                $rol = "<i class='fas fa-dolly'></i>&nbsp;Depósito";
                                                break;
                                            case 3:
                                                $rol = "<i class='fas fa-users'></i>&nbsp;Cliente";
                                                break;
                                        }
                                    ?>

                                        <a class="dropdown-item" href="../../../control/controlCambioRoles.php?rol=<?php echo $idRolAction ?>"><?php echo $rol ?></a>

                                    <?php
                                    }
                                    ?>

                                </div>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>