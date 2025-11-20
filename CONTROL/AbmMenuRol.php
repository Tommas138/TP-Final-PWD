<?php

include_once __DIR__ . '/../MODELO/MenuRol.php';
Class AbmMenuRol {

    private function cargarObjeto($param) {
        $obj = null;
        if (array_key_exists('idmenu', $param) && array_key_exists('idrol', $param)) {
            $objMenu = new Menu();
            $objMenu->setIdMenu($param['idmenu']);
            $objMenu->cargar();

            $objRol = new Rol();
            $objRol->setIdRol($param['idrol']);
            $objRol->cargar();

            $obj = new MenuRol();
            $obj->set($objMenu, $objRol);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param) {
        $obj = null;
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $obj = new MenuRol();
            $obj->set($param['idmenu'], $param['idrol']);
            $obj->cargar();
        }
        return $obj;
    }

    private function seteadosCamposClaves($param) {
        $resp = false;
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $resp = true;
        }
        return $resp;
    }

    public function alta($param) {
        $resp = false;
        $objMenuRol = new MenuRol();
        $abmMenu = new AbmMenu();
        $listaMenu = $abmMenu->buscar(['idmenu' => $param['idmenu']]);
        $abmRol = new AbmRol();
        $objRol = $abmRol->buscar(['idrol' => $param['idrol']]);
        $objMenuRol->set($listaMenu[0], $objRol[0]);

        if ($objMenuRol->insertar()) {
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

    public function buscar($param) {
        $where = " true ";
        if ($param <> null) {
            if (isset($param['idmenu'])) 
                $where .= " AND idmenu = " . $param['idmenu'];
            if (isset($param['idrol']))
                $where .= " AND idrol = " . $param['idrol'];
        }
        $objMenuRol = new MenuRol();
        $arreglo = $objMenuRol->listar($where);
        return $arreglo;
        
    }

    public function buscarRolesMenu($obj) {
        $listaRol = [];
        $listaRol = $this->buscar(null);
        if ($listaRol != "") {
            $roles = [];
            foreach ($listaRol as $menuRol) {
                if ($menuRol->getIdMenu()->getIdMenu() == $obj->getIdMenu()) {
                    $rolDesc = $menuRol->getIdRol()->getRolDescripcion();
                    array_push($roles, $rolDesc);
                }
            }
        }
        return $roles;
    }
}
