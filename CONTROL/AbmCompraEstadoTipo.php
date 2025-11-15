<?php

Class AbmCompraEstadoTipo {

    private function cargarObjeto($param) {
        $obj = null;

        if (array_key_exists('idcompraestadotipo', $param) && array_key_exists('cetdescripcion', $param) 
            && array_key_exists('cetdetalle', $param)) {
        $obj = new CompraEstadoTipo();
        $obj->set($param['idcompraestadotipo'], $param['cetdescripcion'], $param['cetdetalle']);
    }
    return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idcompraestadotipo'])) {
            $obj = new CompraEstadoTipo();
            $obj->set($param['idcompraestadotipo'], null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['idcompraestadotipo'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param) {
        $resp = false;
        $objCompraEstadoTipo = $this->cargarObjeto($param);

        if ($objCompraEstadoTipo != null && $objCompraEstadoTipo->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstadoTipo = $this->cargarObjetoConClave($param);
            if ($objCompraEstadoTipo != null && $objCompraEstadoTipo->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstadoTipo = $this->cargarObjeto($param);
            if ($objCompraEstadoTipo != null && $objCompraEstadoTipo->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompraestadotipo']))
                $where .= " AND idcompraestadotipo = " . $param['idcompraestadotipo'];
            if (isset($param['cetdescripcion']))
                $where .= " AND cetdescripcion = " . $param['cetdescripcion'];
            if (isset($param['cetdetalle']))
                $where .= " AND cetdetalle = '" . $param['cetdetalle'] . "'";
        }
        $objCompraEstadoTipo = new CompraEstadoTipo();
        $arreglo = $objCompraEstadoTipo->listar($where);
        return $arreglo;
    }
}