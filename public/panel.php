<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Incluimos los archivos necesarios
 *
 *--------------------------------------------------------------------------------
================================================================================*/
IncluirCarpeta(BASE_DIR."_core/utils");
IncluirCarpeta(BASE_DIR."_core/modelos");
require_once(BASE_DIR."_core/APIs/database/mysql.php");

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Iniciamos clases escenciales
 *
 *--------------------------------------------------------------------------------
================================================================================*/
//Sesion::Iniciar();
//Conexion::Iniciar();

$path = BASE_DIR . "public/vistas";
$archivo = Peticion::getPeticion();

if($archivo == "") {
    $archivo = "index/";
}

if($archivo[ strlen($archivo) - 1 ] == "/") {
    $archivo = str_replace("/", ".php", $archivo);
} else {
    $archivo .= ".php";
}

$ruta = "{$path}/{$archivo}";

if( !(file_exists($ruta) && is_file($ruta)) ) {
    require_once(BASE_DIR."public/vistas/404.php");
} else {
    require_once($ruta);
}