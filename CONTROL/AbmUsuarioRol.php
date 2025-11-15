<?php

Class AbmUsuarioRol {

    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('idusuario', $param) && array_key_exists('idrol', $param)) {
            $objUs = new Usuario();
            $objUs->setIdUsuario($param['idusuario']);
            $objUs->cargar();

            $objRol = new Rol();
            $objRol->setIdRol($param['idrol']);
            $objRol->cargar();
            
            $obj = new UsuarioRol();
            $obj->set($objUs, $objRol);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param[''])) {
            $obj = new UsuarioRol();
            $obj->set($param[''], null);
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
        $resp = false;
        $obj = $this->cargarObjeto($param);
        if ($obj != null && $obj->insertar()) {
            $resp = true;
        }
        return $resp;
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
        $usuarioRol->set($param['idusuario'], $param['idrol']);
        $arreglo = $usuarioRol->listar($where);
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