<?php

include_once __DIR__ . '/../CONTROL/AbmUsuario.php';
include_once __DIR__ . '/../CONTROL/AbmRol.php';
include_once __DIR__ . '/../CONTROL/Session.php';
include_once __DIR__ . '/../CONTROL/AbmUsuarioRol.php';
// include_once __DIR__ . '/../CONTROL/ControlCambioRoles.php'; // No debería ser incluido automáticamente
include_once __DIR__ . '/../CONTROL/ControlIngresoCliente.php';
include_once __DIR__ . '/../CONTROL/AbmCompra.php';
include_once __DIR__ . '/../CONTROL/AbmCompraEstado.php';
include_once __DIR__ . '/../CONTROL/AbmCompraEstadoTipo.php';
include_once __DIR__ . '/../CONTROL/AbmCompraItem.php';
include_once __DIR__ . '/../CONTROL/AbmMenu.php';
include_once __DIR__ . '/../CONTROL/AbmMenuRol.php';
include_once __DIR__ . '/../CONTROL/AbmProducto.php';
include_once __DIR__ . '/../CONTROL/ControlCargaImagenes.php';
include_once __DIR__ . '/../CONTROL/ControlIngresoAdmin.php';
include_once __DIR__ . '/../CONTROL/ControlIngresoManagerDeposito.php';
include_once __DIR__ . '/../CONTROL/ControlVerificarCarritoCliente.php';

function verificarUsuario(Usuario $usuario) {
    $abmUsuario = new AbmUsuario();
    $listaUsuarios = $abmUsuario->buscar(['usnombre' => $usuario->getUsNombre(), 'uspass' => $usuario->getUsPass()]);
    $usuarioEncontrado = false;

    if ($listaUsuarios) {
        $usuarioEncontrado = true;
    }
    return $usuarioEncontrado;
}

function data_submitted()
{
    $_AAux = array();
    if (!empty($_POST)) {
        $_AAux = $_POST;
    } else if (!empty($_GET)) {
        $_AAux = $_GET;
    }
    // No reemplazar valores vacíos, dejar como están
    return $_AAux;
}

function mostrarUsuarios($arregloUsuarios)
{
    $objUsuario = new Usuario();
    $tabla = '<div class="table-responsive"><table class="table col-12 text-center mt-5">
                <thead>
                    <tr>
                        <th scope="col">Identificador</th>
                        <th scope="col">Username</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($arregloUsuarios as $objUsuario) {
        if($objUsuario->getUsDeshabilitado() == "0000-00-00 00:00:00"){
            $tabla .= '<tr>' .
            '<td>' . $objUsuario->getIdUsuario() . '</td>' .
            '<td>' . $objUsuario->getUsNombre() . '</td>' .
            '<td>' . $objUsuario->getUsMail() . '</td>' .
            '<td>
            <a href="../../VISTA/ACCION/actualizarLogin.php">Editar</a>
            <a href="../../VISTA/ACCION/eliminarLogin.php">Borrar</a>
            </td></tr>';
        }else{
            $tabla .= '<tr>' .
            '<td class="table-danger">' . $objUsuario->getIdUsuario() . '</td>' .
            '<td class="table-danger">' . $objUsuario->getUsNombre() . '</td>' .
            '<td class="table-danger">' . $objUsuario->getUsMail() . '</td>' .
            '<td class="table-danger">
            <a href="abmUsuario.php?id='. $objUsuario->getIdUsuario() .'&accion=activar" class="btn btn-primary">Activar</a>
            </td></tr>';
        }
    }
    $tabla .= "</tbody></table></div>";


    return $tabla;
}

