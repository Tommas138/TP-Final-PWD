<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>.nav-item {
  list-style-type: none;
}
.navbar-nav {
  list-style-type: none;
}</style>
<?php
include_once __DIR__ . '../../../../../UTILS/funciones.php';

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

    <a class="navbar-brand navbar-logo navbar-button " href="../../VISTA/index.php">Dunder Mifflin Store</a>
    <a class="navbar-brand navbar-logo navbar-button" href="../../VISTA/listadoProductos.php">Productos</a>
   <?php
   if ($sesion->activa()) {
    $objUs = new UsuarioRol();
    
    $arrUs = $objUs->listar("idusuario = $idUser");
    $roles = $sesion->getUsRoles();
    if ($roles[0]->getObjRol()->getIdRol() == 1 || $roles[0]->getObjRol()->getIdRol() == 2 ) {
    
         if ($sesion->activa()) {
                        
                        if ($roles[0]->getObjRol()->getIDRol() == 1 || $roles[0]->getObjRol()->getIdRol() == 2) {
                        foreach ($sesion->getUsRoles() as $rol) {

                            $abmMenuRol = new AbmMenuRol();
                            $arrayMenusRol = $abmMenuRol->buscar(['idrol' => $rol->getObjRol()->getIdRol()]);

                            if (count($arrayMenusRol) > 0) {
                                $abmMenu = new AbmMenu();
                                $idMenu = $arrayMenusRol[0]->getObjMenu()->getIdMenu();
                              
                                $arrayMenus = $abmMenu->buscar(["idmenu" => $idMenu]);
                                if (count($arrayMenus) > 0) {
                                    $idPadre = $arrayMenus[0]->getIdPadre();
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
                                                            $enlace .= $subMenu->getMedescripcion() . '.php';
                                                            break;
                                                        case '2':
                                                            $enlace .= $subMenu->getMedescripcion() . '.php';
                                                            break;
                                                        case '3':
                                                            $enlace .=  $subMenu->getMedescripcion() . '.php';
                                                            break;
                                                    }
                                            ?>
                                                    <li><a class="dropdown-item" href="<?php echo $enlace ?>"><?php echo $subMenu->getMeNombre(); ?></a></li>
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
                   }
                    ?>
                </ul>
                <ul class="navbar-nav d-flex">
                    <!-- Icon carrito -->
                    <?php
                    if (($sesion->activa())) {
                        $clienteActivo = false;

                        foreach ($roles as $rol) {
 
                                $clienteActivo = true;

                        }

                        if ($clienteActivo) {
                            $controlVerificarCarrito = new ControlVerificarCarritoCliente();
                            $arrayCarritos = $controlVerificarCarrito->verificarCarrito($idUser);
                            $carrito = $arrayCarritos['carritoHabilitado'];

                            if ($carrito <> "") {
                                $abmItemsCarrito = new AbmCompraItem();
                                $compraItems = $abmItemsCarrito->buscar(['idcompra' => $carrito->getIdCompra()]);
                                $cantidadItemsCarrito = count($compraItems);
                            }
                        }

                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="carrito.php" role="button" aria-haspopup="true" aria-expanded="false">
                                    
                                    <i class="bi bi-minecart"></i> <span class="d-lg-none">Carrito</span><span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cantidadItemsCarrito; ?></span>
                                </a>
                            </li>
                        <?php
                        
                    }
                    ?>
</ul>
                       <ul class="navbar-nav d-flex">
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

                                <a class="dropdown-item" href="../../VISTA/modificar.php"><i class="fas fa-user-cog"></i>&nbsp;Editar Perfil</a>
                                <a class="dropdown-item" href="../../VISTA/compras.php"><i class="fas fa-user-cog"></i>&nbsp;Mis Compras</a>
                            </div>
                        </li>
                        <?php
                     
                      }
                    ?>
                    
                </ul>
            </div>
        </div>
                    <?php   }?>
   <?php if (!$sesion->activa()) { ?>
    <div class="bg-primary text-white p-2 rounded">
        <form action="../index.php">
            <button type="submit" class="btn btn-sm">
                Iniciar Sesion
            </button>
        </form>
  <?php  } else {
    ?>
        <div class="bg-primary text-white p-2 rounded">
        <form action="../VISTA/acciones/cerrarSesion.php">
            <button type="submit" class="btn btn-sm">
                Cerrar Sesion
            </button>
        </form>
        <?php } 
        ?>
    </nav>
