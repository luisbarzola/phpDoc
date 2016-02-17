<?php

/**
 * Metodo para autolodear clases obtenido de
 * http://zaemis.blogspot.com.ar/2012/05/writing-minimal-psr-0-autoloader.body
 * Cumple con el estandar PSR-0.
 *
 * Autoloader de clases de WEBGIS. Dado que el nombre físico de la carpeta
 *  vendor puede cambiar (durante desarrollo principalmente), se incluye en todo
 *  namespace el vendor definido, y para buscar la ruta física de cada clase,
 *  se remueve el VENDOR.
 *
 * @param string $classname Nombre de la clase a cargar.
 *
 * @return void
 */
$myAutoloader = function($classname)
{
    $vendor = 'Doc\\';

    $classname = str_replace($vendor, '', $classname);
    $classname = ltrim($classname, "\\");
    preg_match('/^(.+)?([^\\\\]+)$/U', $classname, $match);
    $classname = str_replace("\\", "/", $match[1]) .
        str_replace(array("\\", "_"), "/", $match[2]) .
        ".php";

    if (file_exists(__DIR__ . '/' . $classname)) {
        include_once __DIR__ . '/' .$classname;
    }
};

//Registramos el autoloader en PHP.
spl_autoload_register($myAutoloader);