<?php

class Session
{
    // Constructor
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    // Getters
    public function getIdUsuario()
    {
        return $_SESSION['idusuario'] ?? null;
    }

    public function getIDRol()
    {
        return $_SESSION['idrol'] ?? null;
    }


    public function getUsNombre()
    {
        return $_SESSION['usnombre'] ?? null;
    }

    public function getUsPass()
    {
        return $_SESSION['uspass'] ?? null;
    }

    public function getUsRoles()
    {
        return isset($_SESSION['roles']) ? $_SESSION['roles'] : [];
    }

    // Setters
    public function setIdUsuario($idUsuario)
    {
        $_SESSION['idusuario'] = $idUsuario;
    }

    public function setUsNombre($usNombre)
    {
        $_SESSION['usnombre'] = $usNombre;
    }

    public function setUsPass($usPass)
    {
        $_SESSION['uspass'] = $usPass;
    }

    public function setUsRoles($roles)
    {
        $_SESSION['roles'] = $roles;
    }

    public function mostrarDetallesSesion()
    {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    }


    // Metodos

    /**
     * Inicia la sesión del usuario con los datos proporcionados y asigna sus roles
     * @param int $id ID del usuario
     * @param string $nombre Nombre del usuario
     * @param string $pass Contraseña del usuario (se encripta con MD5)
     */
    public function iniciar($id, $nombre, $pass)
    {
        $abmUsuarioRol = new AbmUsuarioRol();

        $this->setUsNombre($nombre);
        $this->setUsPass(md5($pass));
        
        $idRol = $abmUsuarioRol->buscar(['idusuario' => $id]);
        
        if ($id && $nombre && $pass) {
            $this->setIdUsuario($id);
            
            // Obtener roles del usuario
            $this->setUsRoles($idRol);
        }
    }

    /**
     * Valida la existencia de un usuario en la bd
     * @return array ($inicia, $error)
     */
    public function validar()
    {
        $inicia = false;
        $nombreUsuario = $this->getUsNombre();
        $passUsuario = $this->getUsPass();
        $abmUsuario = new AbmUsuario();
        $where = array();
        $filtro1 = array();
        $filtro1['usnombre'] = $nombreUsuario;
        $filtro2 = array();
        $filtro2['uspass'] = $passUsuario;
        $where['usnombre'] = $nombreUsuario;
        $where['uspass'] = $passUsuario;
        $listaUsuarios = $abmUsuario->buscar($where);
        $username = $abmUsuario->buscar($filtro1);
        $pass =  $abmUsuario->buscar($filtro2);
        $error = "";

        if ($username == null || $pass == null) {
            $error .= "Usuario y/o contraseña incorrecto!";
        }

        if (count($listaUsuarios) > 0) {
            $fechaDes = $listaUsuarios[0]->getUsDeshabilitado();
            if ($fechaDes != "0000-00-00 00:00:00") {
                $error .= "Este usuario se encuentra deshabilitado!";
            } else {
                $inicia = true;
                $this->setIdUsuario($listaUsuarios[0]->getIdUsuario());
            }
            $abmUsuarioRol = new AbmUsuarioRol();
            $arrayBusqueda = ["idusuario" => $listaUsuarios[0]->getIdUsuario()];
            $arrayUsuarioRoles = $abmUsuarioRol->buscar($arrayBusqueda);

            $this->setUsRoles(array($arrayUsuarioRoles[0]->getObjRol()->getIdRol()));
        }

        return array($inicia, $error);
    }


    /**
     * Pone la sesion activa para el usuario loggeado
     * @return boolean $activa
     */
    public function activa()
    {
        $activa = false;
        if (isset($_SESSION['usnombre'])) {
            $activa = true;
        }

        return $activa;
    }


    /**
     * Consigue a un usuario de la bd
     * @return $datosUsuario
     */
    public function getUsuario()
    {
        $abmUsuario = new AbmUsuario();
        $where = ['idusuario' => $this->getIdUsuario()];
        $listaUsuarios = $abmUsuario->buscar($where);

        if ($listaUsuarios >= 1) {
            $datosUsuario = $listaUsuarios[0];
        }
        return $datosUsuario;
    }


    // /**
    //  * Consigue al rol del usuario a loggearse
    //  * @return string $rol
    //  */
    //public function getRol()
    //{
    //    $abmUsuarioRol = new AbmUsuarioRol();
    //    $usuario = $this->getUsuario();
    //    $idUsuario = $usuario->getIdUsuario();
    //    $param = ['idusuario' => $idUsuario];
    //    $listaRolesUsu = $abmUsuarioRol->buscar($param);

    //    if ($listaRolesUsu > 1) {
    //        $rol = $listaRolesUsu;
    //    } else {
    //        $rol = $listaRolesUsu[0];
    //    }

    //    return $rol;
    //}

    /**
     * Destruye la session creada.
     */
    public function cerrarSession()
    {
        session_unset();
        session_destroy();
    }


    /*---------------- MOSTRAR VALORES DE SESSION ----------------*/

    // public function mostrarValorVariables()
    // {
    //     print_r($_SESSION);
    // }
}