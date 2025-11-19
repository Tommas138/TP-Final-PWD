<?php

include_once __DIR__ . '/../MODELO/UsuarioRol.php';
include_once __DIR__ . '/../MODELO/Rol.php';


Class AbmUsuarioRol {

    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('idusuario', $param)) {
            $objUs = new Usuario();
            $objUs->setIdUsuario($param['idusuario']);
            $objUs->cargar();

            $objRol = new Rol();
            $objRol->alta();

            $objRol->cargar();
            
            $obj = new UsuarioRol();
            $obj->set($objUs, $objRol);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $objUsuario = new Usuario();
            $objUsuario->setIdUsuario($param['idusuario']);
            
            $objRol = new Rol();
            $objRol->setIdRol($param['idrol']);
            
            $obj = new UsuarioRol();
            $obj->set($objUsuario, $objRol);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param) {
        $obj = null;
        $obj = $this->cargarObjeto($param);
        $obj->insertar();

        return $obj;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsRol = $this->cargarObjetoConClave($param);
            if ($objUsRol != null && $objUsRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;
        $objUsRol = new UsuarioRol();
        $abmRol = new AbmRol();
        $listaRol = $abmRol->buscar(['idrol' => $param['idrol']]);
        $abmUs = new AbmUsuario();
        $listaUs = $abmUs->buscar(['idusuario' => $param['idusuario']]);
        $objUsRol->set($listaUs[0], $listaRol[0]);
        if ($objUsRol->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idusuario']))
                $where .= " AND idusuario = " . $param['idusuario'];
            if (isset($param['idrol']))
                $where .= " AND idrol = " . $param['idrol'];
        }
        $usuarioRol = new UsuarioRol();
        $arreglo = $usuarioRol->listar($where);
        $usuarioRol->set($arreglo[0]->getObjUsuario()->getIdUsuario(), $arreglo[0]->getObjRol());
        return $arreglo;
    }

    public function buscarRolesUsuario($objUs) {
        $listaUsRol = [];
        $listaUsRol = $this->buscar(null);
        if ($listaUsRol != "") {
            $roles = [];
            foreach ($listaUsRol as $usRol) {
                if ($usRol->getObjUsuario()->getIdUsuario() == $objUs->getIdUsuario()) {
                    $rolId = $usRol->getObjRol()->getIdRol();
                    array_push($roles, $rolId);
                }
            }
        }
        return $roles;
    }
}