<?php

Class AbmRol {

    private function cargarObjeto($param) {
        $rol =  null;
        if (array_key_exists('idrol', $param) && array_key_exists('roldescripcion', $param)) {
            $rol = new Rol();
            $rol->set($param['idrol'], $param['roldescripcion']);
        }
        return $rol;
    }

    private function cargarObjetoConClave($param) {
        $rol = null;
        if (isset($param['idrol'])) {
            $rol = new Rol();
            $rol->set($param['idrol'], null);
        }
        return $rol;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param)) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param) {
        $resp = false;
        $rol = $this->cargarObjeto($param);
        if ($rol != null && $rol->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $rol = $this->cargarObjetoConClave($param);
            if ($rol != null && $rol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificar($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $rol = $this->buscar($param);
            if ($rol[0] != null && $rol[0]->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param != null) {
            if (isset($param['id_rol'])) {
                $where .= " AND idrol = '" . $param['idrol'];
            }

            if (isset($param['roldescripcion'])) {
                $where .= " and roldescripcion = '" . $param['roldescripcion'] . "'";
            }
        }

        $rol = new Rol();
        $rol->set($param['idrol'], $param['roldescripcion']);
        $arreglo = $rol->listar($where);
        return $arreglo;
    }
}