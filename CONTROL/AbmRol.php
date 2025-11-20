<?php

Class AbmRol {

    private function cargarObjeto($param) {
        $rol =  null;
        if (array_key_exists('idrol', $param) && array_key_exists('rodescripcion', $param)) {
            $rol = new Rol();
            $rol->set($param['idrol'], $param['rodescripcion']);
        }
        return $rol;
    }

    private function cargarObjetoConClave($param) {
        $rol = null;
        if (isset($param['idrol'])) {
            $rol = new Rol();
            $rol->set($param['idrol'], 'Cliente');
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
            if (isset($param['idrol'])) {
                $where .= " AND idrol = " . $param['idrol'];
            }
            if (isset($param['rodescripcion'])) {
                $where .= " AND rodescripcion = '" . $param['rodescripcion'] . "'";
            }
        }

        $rol = new Rol();
        if(isset($param["rodescripcion"])){
            $rol->set($param['idrol'], $param["rodescripcion"]);
        } else {
            $rol->set($param['idrol'], rolDescripcion: null);
        }
        $arreglo = $rol->listar($where);
        return $arreglo;
    }
}