<?php

include_once __DIR__ . '/../MODELO/Usuario.php';
include_once __DIR__ . '/../CONTROL/AbmUsuarioRol.php';


class AbmUsuario {
    //Funcion que busca un objeto
    public function buscar($param) {
        $where = "true";
        if ($param != null) {
            if (isset($param['idusuario'])) {
                $where .= " and idusuario ='" . $param['usnombre'] . "'";
            }
            if (isset($param['usnombre'])) {
                $where .= " and usnombre ='" . $param['usnombre'] . "'";
            }
            if (isset($param['uspass'])) {
                $where .= " and uspass ='" . $param['uspass'] . "'";
            }
            if(isset($param['usmail'])) {
                $where .= " and usmail ='" . $param['usmail'] . "'";
            }
            if(isset($param['usdeshabilitado'])) {
                $where .= " and usdeshabilitado ='" . $param['usdeshabilitado'] . "'";
            }
        }
        $usuario = new Usuario();
        // $usuario->set($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
        $usuario->set(1, $param['usnombre'], $param['uspass'], $param['usmail'], null);
        $arreglo = $usuario->seleccionar($where);
        return $arreglo;
    }

    //Definimos la funcion cargarObjeto
    private function cargarObjeto($param) {
        $objUs = null;
        if(array_key_exists('usnombre', $param) && array_key_exists('usmail', $param) && array_key_exists('uspass', $param)) {
            $objUs = new Usuario();
            $pass =md5($param['uspass']);
            $objUs->set('', $param['usnombre'], $pass, $param['usmail'], '');
        }
        return $objUs;
    }

    //Definimos la funcion seteadosCamposClaves
    private function seteadosCamposClaves($param) {
        $resp = false;
        if(isset($param['idusuario'])) {
            $resp = true;
        }
        return $resp;
    }

    //Definimos la funcion cargarObjetoConClave
    private function cargarObjetoConClave($param) {
        $objUs = null;
        if(isset($param['idusuario'])) {
            $objUs = new Usuario();
            $objUs->set($param['idusuario'], null, null, null, null);
        }
        return $objUs;
    }

    //Definimos la funcion modificacion
    public function modificacion($param) {
        $resp = false;
        $lista = $this->buscar(['idusuario' => $param['idusuario']]);
        if ($lista != null) {
            $objUs = new Usuario();
            $pass = md5($param['uspass']);
            $objUs->set($param['idusuario'], $param['usnombre'], $pass, $param['usmail'], $param['usdeshabilitado']);
            if($objUs->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    //Definimos la funcion baja
    public function baja($param) {
        $resp = false;
        $usActual = false;
        if ($param['idusuario'] == $param['idusuariossesion']) {
            $usActual = true;
        }
        if (!$usActual) {
            if ($this->seteadosCamposClaves($param)) {
                $objUsuario = $this->cargarObjetoConClave($param);
                if($objUsuario != null && $objUsuario->eliminar()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    //Definimos la funcion alta
    public function alta($param) {
        $resp = false;
        $objUsuario = null;
        // $busquedaUsuario = ["usnombre" => $param['usnombre']];
        // $busquedaCorreo = ["usmail" => $param['usmail']];
        // $existeUsuario = $this->buscar($busquedaUsuario);
        // $existeCorreo = $this->buscar($busquedaCorreo);
        
        $existeUsuario = $this->buscar($param);

        if (($existeUsuario == null)) {
            $objUsuario = $this->cargarObjeto($param);
            if ($objUsuario->insertar()) {
                $resp = true;
            }
        }
        if ($resp) {
            // $usuarioNuevo = $this->buscar($param);
            // $idUsuario = $usuarioNuevo[0]->getIdUsuario();
            // $idRolUsuario = $param['idrol'];
            // $arrayRolUsuario = ["idrol" => $idRolUsuario, "idusuario" => $idUsuario];
            // $abmUsuarioRol = new abmUsuarioRol();
            // $abmUsuarioRol->alta($arrayRolUsuario);
        }
        return $resp;
    }

    //Definimos la funcion deshabilitar usuario
    //Hace un borrado logico y si ya estaba deshabilitado, lo vuelve habilitar
    public function deshabilitarUsuario($param) {
        $resp = false;
        $objUsuario = $this->cargarObjetoConClave($param);
        $listadoProductos = $objUsuario->seleccionar("idusuario=" . $param['idusuario']);
        if(count($listadoProductos) > 0) {
            $estadoUsuario = $listadoProductos[0]->getUsDeshabilitado();
            if($estadoUsuario == '0000-00-00 00:00:00') {
                if($objUsuario->estado(date("y-m-d h:i:s"))) {
                    $resp = true;
                }
            } else {
                if ($objUsuario->estado()) {
                    $resp = true;
                }
            }
        }

        return $resp;
    }
}