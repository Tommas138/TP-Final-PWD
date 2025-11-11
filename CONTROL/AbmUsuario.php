<?php
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
        $arreglo = Usuario::seleccionar($where);
        return $arreglo;
    }

    //Definimos la funcion cargarObjeto
    private function cargarObjeto($param) {
        $objUs = null;
        if(array_key_exists('usnombre', $param) && array_key_exists('usmail', $param) && array_key_exists('uspass', $param)) {
            $objUs = new Usuario();
            $pass =md5($param['uspass']);
            $objUs->setear('', $param['usnombre'], $pass, $param['usmail'], '');
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
            $objUs->setear($param['idusuario'], null, null, null, null);
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
            $objUs->setear($param['idusuario'], $param['usnombre'], $pass, $param['usmail'], $param['usdeshabilitado']);
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
            if ($this->seteadoCamposClaves($param)) {
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
        $busquedaUsuario = ["usnombre" => $param['usnombre']];
        $busquedaCorreo = ["usmail" => $param['usmail']];
        $existeUsuario = $this->buscar($busquedaUsuario);
    }
}