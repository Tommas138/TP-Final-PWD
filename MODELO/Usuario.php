<?php

include_once 'conector/BaseDatos.php';

class Usuario {
    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;
    private $mensajeoperacion;

    //Definimos la funcion __construct
    public function __construct () {
        $this->idusuario = "";
        $this->usnombre = "";
        $this->uspass = "";
        $this->usmail = "";
        $this->usdeshabilitado = "";
        $this->mensajeoperacion = "";
    }

    //Definimos los set y los get
    public function getIdUsuario () {
        return $this->idusuario;
    }
    public function getUsNombre () {
        return $this->usnombre;
    }
    public function getUsPass () {
        return $this->uspass;
    }
    public function getUsMail () {
        return $this->usmail;
    }
    public function getUsDeshabilitado () {
        return $this->usdeshabilitado;
    }
    public function getMensajeOperacion () {
        return $this->mensajeoperacion;
    }

    public function setIdUsuario ($idusuario) {
        $this->idusuario = $idusuario;
    }
    public function setUsNombre ($usnombre) {
        $this->usnombre = $usnombre;
    }
    public function setUsPass ($uspass) {
        $this->uspass = $uspass;
    }
    public function setUsMail ($usmail) {
        $this->usmail = $usmail;
    }
    public function setUsDeshabilitado ($usdeshabilitado) {
        $this->usdeshabilitado = $usdeshabilitado;
    }
    public function setMensajeOperacion ($mensajeoperacion) {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //Funcion set para ahorrar pasos
    public function set ($idusuario, $usnombre, $uspass, $usmail, $usdeshabilitado) {
        $this->setIdUsuario($idusuario);
        $this->setUsNombre($usnombre);
        $this->setUsPass($uspass);
        $this->setUsMail($usmail);
        $this->setUsDeshabilitado($usdeshabilitado);
    }

    //Definimos la funcion cargar
    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario=" . $this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > 0) {
                $fila = $base->Registro();
                $this->set($fila['idusuario'], $fila['usnombre'], $fila['uspass'], $fila['usmail'], $fila['usdeshabilitado']);
            }
        } else {
            $this->setMensajeOperacion("usuario->cargar: " . $base->getError());
        }
        return $resp;
    }

    //Definimos la funcion insertar
    public function insertar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('" . $this->getUsNombre() . "','" . $this->getUsPass() . "','" . $this->getUsMail() .  "','0000-00-00 00:00:00');";
        if($base->Iniciar()) {
            if($elid = $base->Ejecutar($sql)) {
                // $this->setIdUsuario($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    //Definimos la funcion de modificar
    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usnombre= '" . $this->getUsNombre() . "', uspass='" . $this->getUsPass() . "', usmail='" . $this->getUsMail() . "', usdeshabilitado= '" . $this->getUsDeshabilitado() . "' Where idusuario=" . $this->getIdUsuario();
        if($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeOperacion("usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->modificar: " . $base->getError());
        }
        return $resp;
    }

    //definimos la funcion estado
    public function estado($param = "") {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usdeshabilitado='" . $param . "'WHERE idusuario=" . $this->getIdUsuario();
        if($base->Iniciar()) {
            if($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->estado: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->estado: " . $base->getError());
        }
        return $resp;
    }

    //Definimos la ffuncion eliminar 
    public function eliminar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario=" . $this->getIdUsuario();
        if($base->Iniciar()) {
            if($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }

    //Definimos la funcion seleccionar
    public function seleccionar($condicion = "") {
        $arreglo = array();
        $obj = null;    
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        if($condicion != "") {
            $sql .= 'WHERE ' . $condicion;
        }
        $res = $base->Ejecutar($sql);
        if($res > 0) {
            while ($fila = $base->Registro()) {
                $obj = new Usuario();
                $obj->set($fila['idusuario'], $fila['usnombre'], $fila['uspass'], $fila['usmail'], $fila['usdeshabilitado']);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("usuario->seleccionar: " . $base->getError());
        }
        return $arreglo;
    } 
}
