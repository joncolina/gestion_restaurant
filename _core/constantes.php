<?php

/*============================================================================
 *
 * Directorios
 * 
============================================================================*/
define("BASE_DIR", str_replace( "\\", "/", dirname(__DIR__) . "/" ));

/*============================================================================
*
* Urls
* 
============================================================================*/
define("PREFIJO_AJAX", "_AJAX");
define("HOST_ACTUAL","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

/*============================================================================
 *
 * Cliente
 * 
============================================================================*/
if($_SERVER['REMOTE_ADDR'] == "::1") 	define("IP_CLIENTE", 			"127.0.0.1");
else 									define("IP_CLIENTE", 			$_SERVER['REMOTE_ADDR']);

/*============================================================================
 *
 * Ruta archivo .ini
 * 
============================================================================*/
define("CONFIG_INI", BASE_DIR."config.ini");

/*============================================================================
 *
 * Meses
 * 
============================================================================*/
define("MESES", [
    "01" => ["nombre" => "Enero", 		"dias" => "31", "dias_bisiesto" => "31"],
    "02" => ["nombre" => "Febrero", 	"dias" => "28", "dias_bisiesto" => "29"],
    "03" => ["nombre" => "Marzo", 		"dias" => "31", "dias_bisiesto" => "31"],
    "04" => ["nombre" => "Abril", 		"dias" => "30", "dias_bisiesto" => "30"],
    "05" => ["nombre" => "Mayo", 		"dias" => "31", "dias_bisiesto" => "31"],
    "06" => ["nombre" => "Junio", 		"dias" => "30", "dias_bisiesto" => "30"],
    "07" => ["nombre" => "Julio", 		"dias" => "31", "dias_bisiesto" => "31"],
    "08" => ["nombre" => "Agosto", 		"dias" => "31", "dias_bisiesto" => "31"],
    "09" => ["nombre" => "Septiembre", 	"dias" => "30", "dias_bisiesto" => "30"],
    "10" => ["nombre" => "Octubre", 	"dias" => "31", "dias_bisiesto" => "31"],
    "11" => ["nombre" => "Noviembre", 	"dias" => "30", "dias_bisiesto" => "30"],
    "12" => ["nombre" => "Diciembre", 	"dias" => "31", "dias_bisiesto" => "31"]
]);

/*============================================================================
 *----------------------------------------------------------------------------
 *
 *	CONSTANTES DE LOS ARCHIVOS .INI
 *
 *----------------------------------------------------------------------------
============================================================================*/

/*============================================================================
*
* Abrimos INI
* 
============================================================================*/
try
{
	$config = parse_ini_file(CONFIG_INI, TRUE);
}
catch(Exception $e)
{
	throw new Exception("Ocurrio un problema al intentar leer el archivo 'config.ini'.");
}

/*============================================================================
*
* Validamos
* 
============================================================================*/
try
{
    if(!isset($config['BaseDatos']['servidor'])) throw new Exception("No existe el parametro <b>servidor</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['puerto'])) throw new Exception("No existe el parametro <b>puerto</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['usuario'])) throw new Exception("No existe el parametro <b>usuario</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['clave'])) throw new Exception("No existe el parametro <b>clave</b> en <b>BaseDatos</b>.");
    if(!isset($config['BaseDatos']['nombre_bd'])) throw new Exception("No existe el parametro <b>nombre_bd</b> en <b>BaseDatos</b>.");
    
    if(!isset($config['Seguridad']['key'])) throw new Exception("No existe el parametro <b>key</b> en <b>Seguridad</b>.");
    if(!isset($config['Seguridad']['auditoria'])) throw new Exception("No existe el parametro <b>auditoria</b> en <b>Seguridad</b>.");
    
    if(!isset($config['Sistema']['nombre'])) throw new Exception("No existe el parametro <b>nombre</b> en <b>Sistema</b>.");
    if(!isset($config['Sistema']['version'])) throw new Exception("No existe el parametro <b>version</b> en <b>Sistema</b>.");
    if(!isset($config['Sistema']['fase'])) throw new Exception("No existe el parametro <b>fase</b> en <b>Sistema</b>.");

    
    if(!isset($config['Areas']['administrador'])) throw new Exception("No existe el parametro <b>administrador</b> en <b>Areas</b>.");
    if(!isset($config['Areas']['gerencial'])) throw new Exception("No existe el parametro <b>gerencial</b> en <b>Areas</b>.");
}
catch(Exception $e)
{
    throw new Exception("Ocurrio un problema al validar los archivos INI.:<br>{$e->getMessage()}");
}

/*============================================================================
*
* Generamos
* 
============================================================================*/
try
{
    define("BD_SERVIDOR", $config["BaseDatos"]['servidor']);
    define("BD_PUERTO", $config["BaseDatos"]['puerto']);
    define("BD_USUARIO", $config["BaseDatos"]['usuario']);
    define("BD_CLAVE", $config["BaseDatos"]['clave']);
    define("BD_NOMBRE", $config["BaseDatos"]['nombre_bd']);
    
    define("SEGURIDAD_KEY", $config["Seguridad"]['key']);
    define("SEGURIDAD_AUDITORIA", $config["Seguridad"]['auditoria']);
    define("AUDITORIA", ( SEGURIDAD_AUDITORIA == "1" ));
    
    define("SISTEMA_NOMBRE", $config["Sistema"]['nombre']);
    define("SISTEMA_VERSION", $config["Sistema"]['version']);
    define("SISTEMA_FASE", $config["Sistema"]['fase']);
    
    define("AREA_ADMIN", $config["Areas"]['administrador']);
    define("AREA_GERENCIAL", $config["Areas"]['gerencial']);

    define("HOST", $config['Sistema']['url_base']);
    define("HOST_AJAX", HOST.PREFIJO_AJAX."/");

    define("HOST_ADMIN", HOST.AREA_ADMIN."/");
    define("HOST_ADMIN_AJAX", HOST_ADMIN.PREFIJO_AJAX."/");

    define("HOST_GERENCIAL", HOST.AREA_GERENCIAL."/");
    define("HOST_GERENCIAL_AJAX", HOST_GERENCIAL.PREFIJO_AJAX."/");
}
catch(Exception $e)
{
    throw new Exception("Ocurrio un problema al definir las constantes INI:<br>{$e->getMessage()}");
}

/*============================================================================
 *
 * ADICINAL 2020-06-11
 * 
============================================================================*/
define("DIR_IMG_REST", BASE_DIR."recursos/restaurantes");
define("HOST_IMG_REST", HOST."recursos/restaurantes");

define("ENVIOS", [
    "COCINA",
    "BAR",
    "POSTRES",
    "TODOS"
]);

define("STATUS_MESAS", [
    1 => [ "nombre" => "DISPONIBLE", "color" => "green" ],
    2 => [ "nombre" => "OCUPADA", "color" => "blue" ],
    3 => [ "nombre" => "CERRADA", "color" => "gray" ],
    4 => [ "nombre" => "RESERVADA", "color" => "red" ]
]);

define("STATUS PEDIDOS", [
    1 => ["nombre" => "SIN CONFIRMAR",  "color_cliente" => "white",     "color_monitoreo" => "white"],
    2 => ["nombre" => "EN ESPERA",      "color_cliente" => "gray",      "color_monitoreo" => "green"],
    3 => ["nombre" => "PREPARANDO",     "color_cliente" => "blue",      "color_monitoreo" => "blue"],
    4 => ["nombre" => "LISTO",          "color_cliente" => "green",     "color_monitoreo" => "none"],
    5 => ["nombre" => "FACTURADO",      "color_cliente" => "none",      "color_monitoreo" => "none"],
    6 => ["nombre" => "ANULADO",        "color_cliente" => "red",       "color_monitoreo" => "red"]
]);