<?php
require_once __DIR__ . '/../../UTILS/funciones.php';


$titulo = 'Nuevo Menú';

$datos = data_submitted();

if (!isset($datos["verificado"])) {
    $controlIngresoManagerDeposito = new ControlIngresoAdmin();
    $controlIngresoManagerDeposito->verificarIngreso("nuevoMenu");
}
include_once '../ACCION/ESTRUCTURA/reusables/header.php';

?>
<header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            <h4>Cargar Nuevo Menú</h4>
        </div>
    </div>
</header>

<div class="container mt-3">
    <div class="col-md-4"></div>
    <div class="offset-md-4">
        <form action="../acciones/accionNuevoMenu.php" method="post" class="col-md-6 mt-3 " id="menuNuevo" name="menuNuevo">
            <div class="">
                <div class="form-floating mt-3">
                    <input class="form-control" id="menombre" name="menombre" type="text" placeholder="Nombre" required>
                    <label for="menombre">Nombre</label>
                </div>
            </div>
            <div class="">
                <div class="form-floating mt-3">
                    <input class="form-control" id="medescripcion" name="medescripcion" type="text" placeholder="Descripción" required>
                    <label for="medescripcion">Descripción</label>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="mt-4">
                        <input class="form-check-input" id="idpadre" name="idpadre" type="radio" value="1">
                        <label for="admin">Admin</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mt-4">
                        <input class="form-check-input" id="idpadre" name="idpadre" type="radio" value="2">
                        <label for="deposito">Depósito</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mt-4">
                        <input class="form-check-input" id="idpadre" name="idpadre" type="radio" value="3">
                        <label for=" cliente">Cliente</label>
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



?>