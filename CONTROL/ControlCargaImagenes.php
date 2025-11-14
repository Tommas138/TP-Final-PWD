<?php

Class ControlCargaImagenes {
    public function cargarImagen($imagen, $idProducto) {
        $nombreArchivoImagen = md5($idProducto) . ".jpeg";
        $dir = $GLOBALS['IMGS'];

        $exito = true;

        if ($nombreArchivoImagen != "") {
            if (!$exito || $imagen['imagen']["error"] > 0) {
                $exito = false;
            }

            $tipoJpeg = strpos(strtoupper($imagen['imagen']["type"]), "JPEG");

            if ($exito && !$tipoJpeg) {
                $exito = false;
            }
        }
        if ($exito) {
            if (!copy($imagen['imagen']['tmp_name'], $dir . $nombreArchivoImagen)) {
                $exito = false;
            }
        }
    }
    public function eliminarImagen($idProducto) {
        $nombreArchivoImagen = md5($idProducto) . ".jpeg";
        $dir = $GLOBALS['IMGS'] . $nombreArchivoImagen;

        if (!is_null($dir)) {
            unlink($dir);
        }
    }
}