<?php
class Usuario {
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private $mensajeOperacion;

    //Definimos la funcion __construct
    public function __construct () {
        $this->idUsuario = "";
        $this->usNombre = "";
        $this->usPass = "";
        $this->usMail = "";
        $this->usDeshabilitado = "";
        $this->mensajeOperacion = "";
    }

    //Definimos los set y los get
    public function getIdUsuario () {
        return $this->idUsuario;
    }
    public function getUsNombre () {
        return $this->usNombre;
    }
    public function getUsPass () {
        return $this->usPass;
    }
    public function getUsMail () {
        return $this->usMail;
    }
    public function getUsDeshabilitado () {
        return $this->usDeshabilitado;
    }
    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setIdUsuario () {
        $this->idUsuario = $idUsuario;
    }
    public function setUsNombre () {
        $this->usNombre = $usNombre;
    }
    public function setUsPass () {
        $this->usPass = $usPass;
    }
    public function setUsMail () {
        $this->usMail = $usMail;
    }
    public function setUsDeshabilitado () {
        $this->usDeshabilitdo = $usDeshabilitado;
    }
    public function setMensajeOperacion () {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //Definimos la funcion setear
    public function setear ($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado, $mensajeOperacion) {
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
    }

    //Definimos la funcion cargar
    public function cargar() {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idUsuario=" . $this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar(sql);
            if ($res > 0) {
                $fila = $base->Registro();
                $this->setear($fila['idusuario'], $fila['usnombre'], $fila['uspass'], $fila['usmail'], $fila['usdeshabilitado']);
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
                $this->setIdUsuario($elid);
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
            if($base->Ejecuta($sql)) {
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
        $sql = "DELETE FROM usuario WHERE idusuario=" . $this->getIdUSuario();
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
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario";
        if($condicion != "") {
            $sql .= 'WHERE ' . $condicion;
        }
        $res = $base->Ejecutar($sql);
        if($res > 0) {
            while ($fila = $base->Registro()) {
                $obj = new Usuario();
                $obj->setear($fila['idusuario'], $fila['usnombre'], $fila['uspass'], $fila['usmail'], $fila['usdeshabilitado']);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensajeOperacion("usuario->seleccionar: " . $base->getError());
        }
        return $arreglo;
    } 
}
