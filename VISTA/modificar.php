
<style>
    body {
        display: flex; /* Habilita Flexbox */
        flex-direction: column; /* Organiza los elementos verticalmente */
        min-height: 100vh; /* Asegura que el body ocupe al menos la altura de la ventana */
        margin-bottom: 0; /* Asegura que no haya margen extra abajo */
    }
</style>
<?php
include_once '../CONTROL/Session.php';

$session = new Session();
if(!$session->getIDSesionActual()){
    header("Location: ../index.php");

}else{
    require_once __DIR__ . '/../UTILS/funciones.php';
    include_once 'ACCION/ESTRUCTURA/reusables/header.php';
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
        <form action="acciones/accionActualizarUsuario.php" method="post" class="col-md-6 mt-3 " id="actualizarUsuario" name="actualizarUsuario">
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
include_once '../VISTA/ACCION/ESTRUCTURA/reusables/footer.php';
?>