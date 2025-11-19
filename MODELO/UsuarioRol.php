<?php

class UsuarioRol
{
    private $objRol;
    private $objUsuario;
    private $mensajeOperacion;
    private $objID;


    public function __construct()
    {
        $this->objUsuario = null;
        $this->objRol = null;
        $this->objID = "";
        $this->mensajeOperacion = "";
    }

    public function getObjUsuario()
    {
        return $this->objUsuario;
    }

    public function getObjRol()
    {
        return $this->objRol;
    }
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function getObjID()
    {
        return $this->objID;
    }

    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }
    public function setObjRol($objRol)
    {
        $this->objRol = $objRol;
    }
    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function set($objUsuario, $objRol)
    {
        $this->setObjUsuario($objUsuario);
        $this->setObjRol($objRol);
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getObjUsuario()->getIdUsuario() . " AND idrol = " . $this->getObjRol()->getIdRol();

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $row = $base->Registro();
                $objUsuario = null;
                if ($row['idusuario'] != null) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->cargar();
                }
                $objRol = null;
                if ($row['idrol'] != null) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();
                }
                $this->set($row['idusuario'], $row['idrol']);;
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Cargar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $objUsuario = $this->getObjUsuario();
        $sql = "INSERT INTO usuariorol (idusuario, idrol) VALUES ( '" . $objUsuario->getIdUsuario() . "','" . $this->getObjRol()->getIdRol() . "')";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->Insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Insertar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminarPorID($id)
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idusuario=" . $id;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->eliminar: " . $base->getError());
        }
        return $resp;
    }



    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        // Se corrige DELETE * FROM idusuario... por DELETE FROM usuariorol WHERE...
        $sql = "DELETE * FROM usuariorol WHERE idusuario=" . $this->getObjUsuario()->getIdUsuario() . " AND idrol=" . $this->getObjRol()->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->Eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Eliminar: " . $base->getError());
        }
        return $resp;
    }

    public function listar($param = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        if ($param != "") {
            $sql .= ' WHERE ' . $param;
        }

        $res = $base->Ejecutar($sql);

        if ($res > 0) {
            while ($row = $base->Registro()) {
                $objUsuario = null;
                if ($row['idusuario'] != null) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->cargar();
                }
                $objRol = null;
                if ($row['idrol'] != null) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->cargar();
                }
                $obj = new UsuarioRol();
                $obj->set($objUsuario, $objRol);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Listar: " . $base->getError());
        }
        return $arreglo;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idUsuario = $this->getObjUsuario()->getIdUsuario();
        $idRol = $this->getObjRol()->getIdRol();
        $sql = "UPDATE usuariorol SET idrol = " . $idRol . " WHERE idusuario = " . $idUsuario;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->Modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->Modificar: " . $base->getError());
        }
        return $resp;
    }
}
