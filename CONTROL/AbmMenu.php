<?php
include_once __DIR__ . '/../MODELO/Menu.php';
Class AbmMenu {

    private function cargarObjeto($param) {
        $obj = null;
        //(opcional), menombre, menurl, idpadre (opcional)
        if ($param <> null && (array_key_exists('menombre', $param) || array_key_exists('idmenu', $param))) {
            $id = isset($param['idmenu']) ? $param['idmenu'] : '';
            $menombre = isset($param['menombre']) ? $param['menombre'] : '';
            $medescripcion = isset($param["medescripcion"]) ? $param["medescripcion"] : "";
            $medeshabilitado = isset($param["medeshabilitado"]) ? $param["medeshabilitado"] : "";


            // So hay padre lo buscamos y cargamos para dsps setearlo
            $objPadre = null;
            if (isset($param['idpadre']) && $param['idpadre'] !== '') {
                $objPadre = new Menu();
                $objPadre->set($param['idpadre'], null, null, null, null);
                $objPadre->cargar();
            }

            $obj = new Menu();
            $obj->set($id, $menombre,  $objPadre,$medescripcion,$medeshabilitado);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idmenu'])) {
            $obj = new Menu();
            $obj->set($param['idmenu'], null, null, null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['idmenu'])) {
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
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function modificacion($param) {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null && $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param = "") {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idmenu']))
                $where .= " AND idmenu = " . $param['idmenu'];
            if (isset($param['menombre']))
                $where .= " AND menombre = '" . $param['menombre'] . "'";
            if (isset($param['menurl']))
                $where .= " AND idpadre = '" . $param['idpadre'] . "'";
        }
        $menu = new Menu();
        $arreglo = $menu->listar($where);
        return $arreglo;
    }


    public function deshabilitarMenu($param)
    {
        $resp = false;
        $objMenu = $this->cargarObjetoConClave($param);
        $listadoMenus = $objMenu->listar("idmenu=" . $param['idmenu']);
        if (count($listadoMenus) > 0) {
            $estadoMenu = $listadoMenus[0]->getMeDeshabilitado();
            if ($estadoMenu == '0000-00-00 00:00:00') {
                if ($objMenu->estado(date("Y-m-d H:i:s"))) {
                    $resp = true;
                }
            } else {
                if ($objMenu->estado()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }
}