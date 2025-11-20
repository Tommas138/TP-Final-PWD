<?php

include_once '../../CONTROL/Session.php';

$session = new Session();

if(!$session->getIDSesionActual() || $session->getIDSesionActual() != 1){
    header("Location: ../../index.php");
}else{
    require_once __DIR__ . '/../../UTILS/funciones.php';
    include_once '../ACCION/ESTRUCTURA/reusables/header.php';
}


$titulo = 'Actualizar Menú';
$datos = data_submitted();
$abmMenu = new AbmMenu();
$objMenu = $abmMenu->buscar(["idmenu" => $datos['idmenu']]);

$listaMenus = $abmMenu->buscar();
?>
<div class="container mt-3">
    <h4 class="text-center">Actualizar Menú</h4>
    <div class="col-md-4"></div>
    <div class="offset-md-4">
        <form action="../acciones/accionActualizarMenu.php" method="post" class="col-md-6 mt-3 " id="actualizarMenu" name="actualizarMenu">
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="idmenu" name="idmenu" type="text" placeholder="ID Menu" value="<?php echo $objMenu[0]->getIdMenu() ?>" hidden>
                    <label for="idmenu">ID del menú: </label>
                </div>
            </div>
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="menombre" name="menombre" type="text" placeholder="Nombre del menú" value="<?php echo $objMenu[0]->getMeNombre() ?>" required>
                    <label for="menombre">Nombre del menú: </label>
                </div>
            </div>
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="medescripcion" name="medescripcion" type="text" placeholder="Ruta del menú" value="<?php echo $objMenu[0]->getMeDescripcion() ?>" required>
                    <label for="medescripcion">Descripción del menú: </label>
                </div>
            </div>
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="idpadre" name="idpadre" type="text" placeholder="ID Padre" value="<?php echo $objMenu[0]->getIdPadre() ?>" required>
                    <label for="idpadre">ID Padre: </label>
                </div>
            </div>
            <div class=" mb-3">
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Modificar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
    include_once '../../VISTA/ACCION/ESTRUCTURA/reusables/footer.php';
?>