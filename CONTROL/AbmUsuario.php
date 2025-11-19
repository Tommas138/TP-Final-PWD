<?php

include_once __DIR__ . '/../MODELO/Usuario.php';
include_once __DIR__ . '/../CONTROL/AbmUsuarioRol.php';
include_once __DIR__ . '/../CONTROL/AbmCompra.php';

class AbmUsuario {
    //Funcion que busca un objeto
    public function buscar($param = "") {
        $where = "true";
        if ($param != null) {
            if (isset($param['idusuario'])) {
                $where .= " and idusuario ='" . $param['idusuario'] . "'";
            }
            if (isset($param['usnombre'])) {
                $where .= " and usnombre ='" . $param['usnombre'] . "'";
            }
            if (isset($param['uspass'])) {
                $where .= " and uspass ='" . md5($param['uspass']) . "'";
            }
            if(isset($param['usmail'])) {
                $where .= " and usmail ='" . $param['usmail'] . "'";
            }
            if(isset($param['usdeshabilitado'])) {
                $where .= " and usdeshabilitado ='" . $param['usdeshabilitado'] . "'";
            }
        }
        $usuario = new Usuario();
        // Set only with safely retrieved values; avoid undefined index warnings
        $usnombre = isset($param['usnombre']) ? $param['usnombre'] : '';
        $uspass = isset($param['uspass']) ? $param['uspass'] : '';
        $usmail = isset($param['usmail']) ? $param['usmail'] : '';
        $usuario->set(1, $usnombre, $uspass, $usmail, null);
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
        
        // 1. Verificaciones básicas (Claves seteadas y no borrarse a sí mismo)
        if (!$this->seteadosCamposClaves($param)) {
            return false;
        }
        if (isset($param['idusuariosesion']) && $param['idusuario'] == $param['idusuariosesion']) {
            return false;
        }

        // 2. VERIFICACIÓN DE COMPRAS (Lo nuevo)
        $abmCompra = new AbmCompra();
        // Buscamos compras de este usuario
        $listaCompras = $abmCompra->buscar(['idusuario' => $param['idusuario']]);

        // Si la lista de compras es mayor a 0, tiene historial. NO LO BORRAMOS.
        if (count($listaCompras) > 0) {
            // Aquí retornamos false para evitar el error de SQL (Foreign Key Constraint)
            // El usuario no se borra, pero el sistema no se rompe.
            return false; 
        }

        // 3. ELIMINAR ROLES (Limpieza de dependencias)
        // Si llegamos acá, es porque no tiene compras. Borramos sus roles.
        $abmUsuarioRol = new AbmUsuarioRol();
        $rolesUsuario = $abmUsuarioRol->buscar(['idusuario' => $param['idusuario']]);
        
        foreach ($rolesUsuario as $rolAsignado) {
            $paramBajaRol = [
                'idusuario' => $param['idusuario'], 
                'idrol' => $rolAsignado->getObjRol()->getIdRol()
            ];
            $abmUsuarioRol->baja($paramBajaRol);
        }

        // 4. ELIMINAR USUARIO
        $objUsuario = $this->cargarObjetoConClave($param);
        if($objUsuario != null && $objUsuario->eliminar()) {
            $resp = true;
        }
        
        return $resp;
    }

    /**
     * Carga un nuevo usuario en la base de datos e inicia su sesión
     * @param array datos de usuario
     * @return bool éxito o fracaso
     */
    public function alta($param) {
        $resp = false;
        $objUsuario = null;
        $existeUsuario = $this->buscar($param);

        if (($existeUsuario == null)) {
            $objUsuario = $this->cargarObjeto($param);
            
            if ($objUsuario && $objUsuario->insertar()) {
                $resp = true;
                $idUsuario = $objUsuario->getIdUsuario();
                
                if ($idUsuario) {
                    $arrayRolUsuario = ["idusuario" => $idUsuario];
                    $abmUsuarioRol = new AbmUsuarioRol();
                    $abmUsuarioRol->alta($arrayRolUsuario);
                    $sesion = new Session();
                    $sesion->iniciar($objUsuario->getIdUsuario(), $objUsuario->getUsNombre(), $objUsuario->getUsPass());
                }
            }
        }else{
            $objUsuario = $this->cargarObjeto($param);
            $sesion = new Session();
            $sesion->iniciar($objUsuario->getIdUsuario(), $objUsuario->getUsNombre(), $objUsuario->getUsPass());
        }


        
        return $resp;
    }

    //Definimos la funcion deshabilitar usuario
    //Hace un borrado logico y si ya estaba deshabilitado, lo vuelve habilitar
    public function deshabilitarUsuario($param) {
        $resp = false;
        $objUsuario = $this->cargarObjetoConClave($param);
        $listadoProductos = $objUsuario->seleccionar("idusuario=" . $param['idusuario']);
        if($listadoProductos != null) {
            print_r($listadoProductos);
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