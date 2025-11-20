<?php

include_once '../../CONTROL/Session.php';


$session = new Session();
if(!$session->getIDSesionActual()){
    header("Location: ../../index.php");

}else if($session->getIDSesionActual() != 1 && $session->getIDSesionActual()){
    header("Location: ../home/index.php");
}else{
    require_once __DIR__ . '/../../UTILS/funciones.php';
    include_once '../ACCION/ESTRUCTURA/reusables/header.php';
}

$titulo = 'Nuevo Menu';

$datos = data_submitted();

if (!isset($datos["verificado"])) {
    $controlIngresoManagerDeposito = new ControlIngresoAdmin();
    $controlIngresoManagerDeposito->verificarIngreso("nuevoUsuario");
}

?>
<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            <h4>Cargar nuevo usuario</h4>
        </div>
    </div>
</header>

<div class="container mt-3">
    <div class="offset-md-4">
        <form action="../acciones/accionNuevoUsuario.php" method="post" class="col-md-6 mt-3 " id="usuarioNuevo" name="usuarioNuevo">
            <div class="">
                <div class="form-floating mt-3">
                    <input class="form-control" id="usnombre" name="usnombre" type="text" placeholder="Nombre" required>
                    <label for="usnombre">Nombre</label>
                </div>
            </div>

            <div class="">
                <div class="form-floating mt-3">
                    <input class="form-control" id="usmail" name="usmail" type="text" placeholder="Email" required>
                    <label for="usmail">Email</label>
                </div>
            </div>

            <div class="">
                <div class="form-floating mt-3">
                    <input class="form-control" id="uspass" name="uspass" type="text" placeholder="Contraseña" required>
                    <label for="uspass">Contraseña</label>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="mt-4">
                        <input class="form-check-input" id="admin" name="idrol" type="radio" value="1">
                        <label for="admin">Admin</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mt-4">
                        <input class="form-check-input" id="deposito" name="idrol" type="radio" value="2">
                        <label for="deposito">Depósito</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mt-4">
                        <input class="form-check-input" id="cliente" name="idrol" type="radio" value="3">
                        <label for="cliente">Cliente</label>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-3">
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Cargar</button>
                </div>
            </div>
        </form>
    </div>

</div>

<?php

include_once '../estructura/footer.php';

?>