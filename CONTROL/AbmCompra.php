<?php

include_once __DIR__ . '/../MODELO/Compra.php';
include_once __DIR__ . '/../MODELO/Usuario.php';

Class AbmCompra {

    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('idusuario', $param)) {

            $objUsuario = new Usuario();
            $objUsuario->setIdUsuario($param['idusuario']);
            $objUsuario->cargar();

            $obj = new Compra();
            $obj->set('', '', $objUsuario);
        }
        return $obj;
    } 

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idcompra'])) {
            $obj = new Compra();
            $obj->set($param['idcompra'], null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['idcompra'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta ($param) {
        $resp = false;
        // Para crear un nuevo carrito, solo necesitamos idusuario
        if (array_key_exists('idusuario', $param)) {
            $objCompra = $this->cargarObjeto($param);
            if ($objCompra != null && $objCompra->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param) {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompra'])) 
                $where .= " AND idcompra = " . $param['idcompra'];
            if (isset($param['cofecha']))
                $where .= " AND cofecha = " . $param['cofecha'];
            if (isset($param['idusuario']))
                $where .= " AND idusuario = '" . $param['idusuario'] . "'";
        }
        $unaCompra = new Compra();
        $arreglo = $unaCompra->listar($where);
        return $arreglo;
    }
 }