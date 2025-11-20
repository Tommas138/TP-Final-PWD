<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php
include_once '../../CONTROL/Session.php';

$session = new Session();
if(!$session->getIDSesionActual()){
    header("Location: ../../index.php");

}else{
    require_once __DIR__ . '/../../UTILS/funciones.php';
    include_once '../ACCION/ESTRUCTURA/reusables/header.php';
}

$titulo = 'Actualizar Usuario';

$datos = data_submitted();
$abmUsuario = new AbmUsuario();
$idUsuario = $sesion->getIdUsuario();
$arrayBusqueda = ["idusuario" => $idUsuario];

$listaUsuarios = $abmUsuario->buscar($arrayBusqueda);
$objUsuario = $listaUsuarios[0];

if (isset($listaUsuarios)) {
    $idUsuario = $listaUsuarios[0]->getIdUsuario();
}




?>
<div class="container mt-3">
    <h1 class="text-center">Modificación de Usuario</h1>
    <div class="col-md-4"></div>
    <div class="offset-md-4">
        <form action="../acciones/accionActualizarUsuario.php" method="post" class="col-md-6 mt-3 " id="actualizarUsuario" name="actualizarUsuario">
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="usnombre" name="usnombre" type="text" placeholder="Nombre de usuario" value="<?php echo $objUsuario->getUsnombre(); ?>">
                    <label for="usnombre">Nombre de usuario: </label>
                </div>
            </div>
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="uspass" name="uspass" type="text" placeholder="Contraseña Nueva">
                    <label for="uspass">Contraseña Nueva: </label>
                </div>
            </div>
            <div class="">
                <div class="form-floating mb-3">
                    <input class="form-control" id="usmail" name="usmail" type="text" placeholder="Correo Electronico" value="<?php echo $objUsuario->getUsmail(); ?>">
                    <label for="usmail">Correo Electronico: </label>
                </div>
            </div>

            <input class="form-control" id="idusuario" name="idusuario" type="text" value="<?php echo $objUsuario->getIdUsuario(); ?>" hidden>
            <div class=" mb-3">
                <div class="d-grid">
                    <button class="btn btn-primary mt-3" type="submit">Modificar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include_once '../../VISTA/ACCION/ESTRUCTURA/reusables/footer.php';
?>